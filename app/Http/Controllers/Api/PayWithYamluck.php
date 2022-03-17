<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreateInvoiceController;
use App\Models\Offers;
use App\Models\Payments;
use App\Models\Subscribe;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayWithYamluck extends Controller
{
    public function pay(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $getBalance = DB::table('yamluck')->where('user_id', '=', $checkToken->id)->first();
            $productID = Offers::where('id', $request->product_id)->first();
            $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->first();
            if ($checkSubscribe == null) {
                if ($getBalance->amount >= $productID->share_price) {
                    DB::table('yamluck')->where('user_id', '=', $checkToken->id)->update([
                        'amount' => $getBalance->amount - $productID->share_price
                    ]);
                    Subscribe::create([
                        'user_id' => $checkToken->id,
                        'product_id' => $productID->id,
                        'date' => date('Y-m-d')
                    ]);
                    Offers::where('id', $request->product_id)->update([
                        "curr_subs" => $productID->curr_subs + 1
                    ]);
                    Payments::create([
                        'user_id' => $checkToken->id,
                        'invoice_id' => uniqid(),
                        'bill_to' => $checkToken->email,
                        'payment' => 'Yammluck Balances',
                        "order_date" => date('Y-m-d'),
                        'description' => $productID->title_en,
                        'price' => $productID->share_price
                    ]);
                    $getInvoice = Payments::where([
                        ['user_id', '=', $checkToken->id],
                        ['description', '=', $productID->title_en],
                    ])->first();
                    $tasks_controller = new CreateInvoiceController;
                    $tasks_controller->index('6233477b1ba0a');
                } else {
                    return response()->json(['alert' => 'Balance is not enough'], 404);
                }
            } else {
                return response()->json(['alert' => 'Already Subscribed'], 404);
            }
        }
    }
}
