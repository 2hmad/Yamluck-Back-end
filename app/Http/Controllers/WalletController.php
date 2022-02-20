<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function getActivities(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
            $getID = Users::where('token', $request->token)->first('id');
            return DB::table('activities')->where('user_id', '=', $getID->id)->get();
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
