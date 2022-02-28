<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeWalletController extends Controller
{
    public function recharge(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $checkBalance = DB::table('yamluck')->where('user_id', '=', $checkToken->id)->first();
            if ($checkBalance->amount == 0) {
                DB::table('yamluck')->where('user_id', '=', $checkToken->id)->update([
                    "amount" => $request->amount
                ]);
                DB::table('activities')->insert([
                    "user_id" => $checkToken->id,
                    "type" => "add-balance",
                    "amount" => $request->amount,
                    "date" => date("Y-m-d")
                ]);
                return response()->json(['alert' => 'OK'], 200);
            } else {
                DB::table('yamluck')->where('user_id', '=', $checkToken->id)->update([
                    "amount" => $checkBalance->amount + $request->amount
                ]);
                DB::table('activities')->insert([
                    "user_id" => $checkToken->id,
                    "type" => "add-balance",
                    "amount" => $request->amount,
                    "date" => date("Y-m-d")
                ]);
                return response()->json(['alert' => 'OK'], 200);
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
