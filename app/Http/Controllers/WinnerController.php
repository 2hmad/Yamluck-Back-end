<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WinnerController extends Controller
{
    public function winner(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
            $checkWinner = Winner::where('product_id', $request->product_id)->with('user')->first();
            if ($checkWinner == null) {
                return response('', 404);
            } else {
                return $checkWinner;
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function confirm(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
            $checkWinner = Winner::where('product_id', $request->product_id)->first();
            if ($checkWinner == null) {
                return response('', 404);
            } else {
                if ($checkToken->id == $checkWinner->user_id) {
                    return Winner::where('product_id', $request->product_id)->update([
                        'confirmed' => 1
                    ]);
                }
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
