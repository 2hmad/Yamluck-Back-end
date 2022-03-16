<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Subscribe;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use PayPal\Api\PaymentExecution;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function view()
    {
        return view('paypal');
    }
    public function index(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
            $getProduct = Offers::where('id', $request->product_id)->first();
            $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->first();
            if ($checkSubscribe == null) {
                $this->paypalReturn($request);
                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'))
                );
                $payer = new \PayPal\Api\Payer();
                $payer->setPaymentMethod('paypal');

                $amount = new \PayPal\Api\Amount();
                $amount->setTotal($getProduct->share_price);
                $amount->setCurrency('USD');

                $transaction = new \PayPal\Api\Transaction();
                $transaction->setAmount($amount);

                $redirectUrls = new \PayPal\Api\RedirectUrls();
                $redirectUrls->setReturnUrl(route("paypalReturn"))->setCancelUrl(route("paypalCancel"));

                $payment = new \PayPal\Api\Payment();
                $payment->setIntent('order')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

                try {
                    $payment->create($apiContext);
                    echo $payment;
                    echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
                    return redirect($payment->getApprovalLink());
                } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getData();
                }
            } else {
                return response()->json(['alert' => 'Already subscribed'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function paypalReturn(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        Subscribe::create([
            "user_id" => $checkToken->id,
            "product_id" => $request->product_id,
            "date" => date('Y-m-d')
        ]);
        $getCurrentSubscribers = Offers::where('id', $request->product_id)->first('curr_subs');
        Offers::where('id', $request->product_id)->update([
            "curr_subs" => $getCurrentSubscribers->curr_subs + 1
        ]);
    }
    public function paypalCancel()
    {
        return response()->json(['alert' => 'Transaction Failed'], 404);
    }
}
