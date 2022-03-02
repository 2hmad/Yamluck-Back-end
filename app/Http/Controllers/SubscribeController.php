<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use App\Models\Subscribe;
use App\Models\Users;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->first();
            if ($checkSubscribe == null) {
                Subscribe::create([
                    "user_id" => $checkToken->id,
                    "product_id" => $request->product_id,
                    "date" => date('Y-m-d')
                ]);
                $getCurrentSubscribers = Offers::where('id', $request->product_id)->first('curr_subs');
                Offers::where('id', $request->product_id)->update([
                    "curr_subs" => $getCurrentSubscribers->curr_subs + 1
                ]);
            } else {
                return response()->json(['alert' => 'Already subscribed'], 404);
            }
        }
    }
}
