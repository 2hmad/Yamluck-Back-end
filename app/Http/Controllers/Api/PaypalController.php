<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Subscribe;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPal\Api\PaymentExecution;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    public function view()
    {
        return view('paypal');
    }
    public function index($product_id, $auth)
    {
        $checkToken = Users::where('token', $auth)->first();
        if ($checkToken !== null && $auth !== null && $product_id !== null) {
            $getProduct = Offers::where('id', $product_id)->first();
            if ($getProduct !== null) {
                if ($getProduct->curr_subs < $getProduct->max_subs) {
                    $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $product_id)->first();
                    if ($checkSubscribe == null) {
                        $apiContext = new \PayPal\Rest\ApiContext(
                            new \PayPal\Auth\OAuthTokenCredential(env('PAYPAL_LIVE_CLIENT_ID'), env('PAYPAL_LIVE_CLIENT_SECRET'))
                        );
                        $payer = new \PayPal\Api\Payer();
                        $payer->setPaymentMethod('paypal');

                        $amount = new \PayPal\Api\Amount();
                        $amount->setTotal($getProduct->share_price);
                        $amount->setCurrency('USD');

                        $transaction = new \PayPal\Api\Transaction();
                        $transaction->setAmount($amount);

                        $redirectUrls = new \PayPal\Api\RedirectUrls();
                        $redirectUrls->setReturnUrl(url("api/paypal/return/$product_id/$auth"))->setCancelUrl(route("paypalCancel"));

                        $payment = new \PayPal\Api\Payment();
                        $payment->setIntent('order')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

                        try {
                            $payment->create($apiContext);
                            return redirect($payment->getApprovalLink());
                        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                            echo $ex->getData();
                        }
                    } else {
                        return response()->json(['alert' => 'Already subscribed'], 404);
                    }
                } else {
                    return response()->json(['alert' => 'The offer has reached the maximum number of participants'], 404);
                }
            } else {
                return response()->json(['alert' => 'Offer not found'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function paypalReturn($product_id, $auth)
    {
        $checkToken = Users::where('token', $auth)->first();
        $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $product_id)->first();
        if ($checkSubscribe == null) {
            Subscribe::create([
                "user_id" => $checkToken->id,
                "product_id" => $product_id,
                "date" => date('Y-m-d')
            ]);
            $getCurrentSubscribers = Offers::where('id', $product_id)->first('curr_subs');
            Offers::where('id', $product_id)->update([
                "curr_subs" => $getCurrentSubscribers->curr_subs + 1
            ]);
            return redirect('http://localhost:3000/confirm-payment');
        } else {
            return response()->json(['alert' => 'Already subscribed'], 404);
        }
    }
    public function paypalCancel()
    {
        return response()->json(['alert' => 'Transaction Failed'], 404);
    }
}
