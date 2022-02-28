<?php

namespace App\Http\Controllers;

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
            $getAmount = DB::table('yamluck')->where('user_id', '=', $getID->id)->first();
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
}
