<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreateInvoiceController;
use App\Models\Offers;
use App\Models\Payments;
use App\Models\Subscribe;
use App\Models\Users;
use Exception;
use PayPal\Api\PaymentExecution;

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

                        \PayPal\Core\PayPalConfigManager::getInstance()->addConfigs(['mode' => 'live']);

                        $apiContext = new \PayPal\Rest\ApiContext(
                            new \PayPal\Auth\OAuthTokenCredential(env('PAYPAL_LIVE_CLIENT_ID'), env('PAYPAL_LIVE_CLIENT_ID'))
                        );

                        $apiContext->setConfig(
                            array(
                                'mode' => 'live',
                            )
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
                            echo $payment;
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
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(env('PAYPAL_LIVE_CLIENT_ID'), env('PAYPAL_LIVE_CLIENT_SECRET'))
        );

        $checkToken = Users::where('token', $auth)->first();
        $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $product_id)->first();
        if ($checkSubscribe == null) {
            $paymentId = $_GET['paymentId'];
            $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
            $payerId = $_GET['PayerID'];

            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            try {
                $result = $payment->execute($execution, $apiContext);
                Subscribe::create([
                    "user_id" => $checkToken->id,
                    "product_id" => $product_id,
                    "date" => date('Y-m-d')
                ]);
                $getCurrentSubscribers = Offers::where('id', $product_id)->first('curr_subs');
                Offers::where('id', $product_id)->update([
                    "curr_subs" => $getCurrentSubscribers->curr_subs + 1
                ]);
                $getProduct = Offers::where('id', $product_id)->first();
                Payments::create([
                    'user_id' => $checkToken->id,
                    'invoice_id' => uniqid(),
                    'bill_to' => $checkToken->email,
                    'payment' => 'PayPal',
                    "order_date" => date('Y-m-d'),
                    'description' => $getProduct->title_en,
                    'price' => $getProduct->share_price
                ]);
                $getInvoice = Payments::where([
                    ['user_id', '=', $checkToken->id],
                    ['description', '=', $getProduct->title_en],
                ])->first();
                $tasks_controller = new CreateInvoiceController;
                $tasks_controller->index('6233477b1ba0a');
                return redirect('https://yammluck.com/confirm-payment');
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            }
        } else {
            return response()->json(['alert' => 'Already subscribed'], 404);
        }
    }
    public function paypalCancel()
    {
        return response()->json(['alert' => 'Transaction Failed'], 404);
    }
}
