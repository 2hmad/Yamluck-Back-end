<?php

namespace App\Http\Controllers;

use App\Models\Offers;
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
            if ($getBalance->amount >= $productID->share_price) {
                DB::table('yamluck')->where('user_id', '=', $checkToken->id)->update([
                    'amount' => $getBalance->amount - $productID->share_price
                ]);
            } else {
                return response()->json(['alert' => 'Balance is not enough'], 404);
            }
        }
    }
}
