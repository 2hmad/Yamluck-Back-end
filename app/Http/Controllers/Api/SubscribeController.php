<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreateInvoiceController;
use App\Models\Offers;
use App\Models\Payments;
use App\Models\Subscribe;
use App\Models\Users;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
            $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $request->product_id)->first();
            if ($checkSubscribe == null) {
                Subscribe::create([
                    "user_id" => $checkToken->id,
                    "product_id" => $request->product_id,
                    "date" => date('Y-m-d')
                ]);
                $getCurrentSubscribers = Offers::where('id', $request->product_id)->first();
                Offers::where('id', $request->product_id)->update([
                    "curr_subs" => $getCurrentSubscribers->curr_subs + 1
                ]);
                Payments::create([
                    'user_id' => $checkToken->id,
                    'invoice_id' => uniqid(),
                    'bill_to' => $checkToken->email,
                    'payment' => 'Credit / Debit Card',
                    "order_date" => date('Y-m-d'),
                    'description' => $getCurrentSubscribers->title_en,
                    'price' => $getCurrentSubscribers->share_price
                ]);
                $getInvoice = Payments::where([
                    ['user_id', '=', $checkToken->id],
                    ['description', '=', $getCurrentSubscribers->title_en],
                ])->first();
                $tasks_controller = new CreateInvoiceController;
                $tasks_controller->index($getInvoice->invoice_id);
            } else {
                return response()->json(['alert' => 'Already subscribed'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function getSubscribers(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
            $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->where('product_id', $request->product_id)->first();
            if ($checkSubscribe == null) {
                return response()->json(['alert' => 'User not subscribed'], 404);
            } else {
                return Subscribe::where('product_id', $request->product_id)->with('user')->get();
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
