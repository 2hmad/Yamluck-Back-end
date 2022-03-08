<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use App\Models\Subscribe;
use App\Models\Users;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request, $type)
    {
        if ($type == 'offer') {
            $headerToken = $request->header('Authorization');
            $checkToken = Users::where('token', $headerToken)->first();
            if ($checkToken !== null && $headerToken !== null && $request->product_id !== null) {
                $id = $request->product_id;
                if ($request->card_holder !== "" && $request->card_number !== "" && $request->expire_month !== "" && $request->expire_year !== "" && $request->cvv !== "") {
                    $getOffer = Offers::where('id', $id)->first();
                    if ($getOffer->curr_subs < $getOffer->max_subs) {
                        $checkSubscribe = Subscribe::where('user_id', $checkToken->id)->first();
                        if ($checkSubscribe == null) {
                            Subscribe::create([
                                'user_id' => $checkToken->id,
                                'product_id' => $id,
                                'date' => date('Y-m-d')
                            ]);
                            Offers::where('id', $id)->update([
                                "curr_subs" => $getOffer->curr_subs + 1
                            ]);
                        } else {
                            return response()->json(['alert' => 'Already Subscribe'], 404);
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
            if ($checkToken !== null && $headerToken !== null && $request->amount !== null) {
                $amount = $request->amount;
                $cardHolder = $request->card_holder;
                $cardNumber = $request->card_number;
                $cardMonth = $request->expire_month;
                $cardYear = $request->expire_year;
                $cardCvv = $request->cvv;
                if ($cardHolder !== "" && $cardNumber !== "" && $cardMonth !== "" && $cardYear !== "" && $cardCvv !== "") {
                } else {
                    return response()->json(['alert' => 'Data is missing'], 404);
                }
            }
        } else {
            return response()->json(['alert' => 'Invalid type'], 404);
        }
    }
}
