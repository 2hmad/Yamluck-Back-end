<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function getAmount(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $getID = Users::where('token', $headerToken)->first('id');
            $getAmount = DB::table('yamluck')->where('user_id', '=', $getID->id)->get();
            if ($getAmount == null) {
                return 0;
            } else {
                return $getAmount;
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function getActivities(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $getID = Users::where('token', $headerToken)->first('id');
            return DB::table('activities')->where('user_id', '=', $getID->id)->orderBy('id', 'DESC')->get();
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function recharge(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $checkToken->block !== '1') {
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
