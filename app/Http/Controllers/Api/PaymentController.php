<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreateInvoiceController;
use App\Models\Notifications;
use App\Models\Offers;
use App\Models\Payments;
use App\Models\Subscribe;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function pay(Request $request, $type)
    {
        if ($type == 'offer') {
            $headerToken = $request->header('Authorization');
            $checkToken = Users::where('token', $headerToken)->first();
            if ($checkToken !== null && $headerToken !== null && $request->product_id !== null && $checkToken->block !== '1') {
                $id = $request->product_id;
                if ($request->card_holder !== "" && $request->card_number !== "" && $request->expire_month !== "" && $request->expire_year !== "" && $request->cvv !== "") {
                    $getOffer = Offers::where('id', $id)->first();
                    if ($getOffer->curr_subs < $getOffer->max_subs) {
                        $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $request->product_id)->first();
                        if ($checkSubscribe == null) {
                            Subscribe::create([
                                'user_id' => $checkToken->id,
                                'product_id' => $id,
                                'date' => date('Y-m-d')
                            ]);
                            Offers::where('id', $id)->update([
                                "curr_subs" => $getOffer->curr_subs + 1
                            ]);
                            Payments::create([
                                'user_id' => $checkToken->id,
                                'invoice_id' => uniqid(),
                                'bill_to' => $checkToken->email,
                                'payment' => 'Credit / Debit Card',
                                "order_date" => date('Y-m-d'),
                                'description' => $getOffer->title_en,
                                'price' => $getOffer->share_price
                            ]);
                            Notifications::create([
                                'user_id' => $checkToken->id,
                                'sender' => "Yammluck",
                                'subject_en' => "Payment completed successfully",
                                'subject_ar' => "???? ?????????? ??????????",
                                "content_en" => "You have successfully completed the payment for the subscription to the product: " . $getOffer->title_en,
                                "content_ar" => "?????? ?????? ?????????? ?????????? ?????????? ???? ???????????????? ??????????: " . $getOffer->title_ar,
                                "date" => Carbon::now()->toDateTimeString(),
                            ]);
                            $getInvoice = Payments::where([
                                ['user_id', '=', $checkToken->id],
                                ['description', '=', $getOffer->title_en],
                            ])->first();
                            $getBillTo = $getInvoice->bill_to;
                            Mail::send('invoice', ['id' => $getInvoice->id, 'user_id' => $getInvoice->user_id, 'invoice_id' => $getInvoice->invoice_id, 'bill_to' => $getInvoice->bill_to, 'payment' => $getInvoice->payment, 'order_date' => $getInvoice->order_date, 'description' => $getInvoice->description, 'publisher' => $getInvoice->publisher, 'price' => $getInvoice->price], function ($message) use ($getBillTo) {
                                $message->to($getBillTo)->subject('Yammluck Invoice');
                            });
                        } else {
                            return response()->json(['alert' => 'Already Subscribed'], 404);
                        }
                    } else {
                        return response()->json(['alert' => 'Offer has expired'], 404);
                    }
                } else {
                    return response()->json(['alert' => 'Data is missing'], 404);
                }
            } else {
                return response()->json(['alert' => 'Invalid token'], 404);
            }
        } elseif ($type == 'wallet') {
            $headerToken = $request->header('Authorization');
            $checkToken = Users::where('token', $headerToken)->first();
            if ($checkToken !== null && $headerToken !== null && $request->amount !== null && $checkToken->block !== '1') {
                $amount = $request->amount;
                $cardHolder = $request->card_holder;
                $cardNumber = $request->card_number;
                $cardMonth = $request->expire_month;
                $cardYear = $request->expire_year;
                $cardCvv = $request->cvv;
                if ($cardHolder !== "" && $cardNumber !== "" && $cardMonth !== "" && $cardYear !== "" && $cardCvv !== "") {
                    $getAmount = DB::table('yamluck')->where('user_id', '=', $checkToken->id)->first();
                    DB::table('yamluck')->where('user_id', '=', $checkToken->id)->update([
                        'amount' => $getAmount->amount + $amount
                    ]);
                    DB::table('activities')->insert([
                        "user_id" => $checkToken->id,
                        "type" => "add-balance",
                        "amount" => $request->amount,
                        "date" => date("Y-m-d")
                    ]);
                    Notifications::create([
                        'user_id' => $checkToken->id,
                        'sender' => "Yammluck",
                        'subject_en' => "Your wallet has been recharged",
                        'subject_ar' => "???? ?????? ?????????????? ??????????",
                        "content_en" => "Your wallet has been successfully recharged with " . $request->amount . ' S.R',
                        "content_ar" => "?????? ?????????? ?????? ???????????? ?????????? ?????????? " . $request->amount . ' ??.??',
                        "date" => Carbon::now()->toDateTimeString(),
                    ]);
                    return response()->json(['alert' => 'OK'], 200);
                } else {
                    return response()->json(['alert' => 'Data is missing'], 404);
                }
            }
        } else {
            return response()->json(['alert' => 'Invalid type'], 404);
        }
    }
}
