<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Verification;
use Carbon\Carbon;
use Dot2hmad\LaravelTwilio\Facades\LaravelTwilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckPhoneController extends Controller
{
    public function update(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->phone !== null) {
            $updatePhone = Users::where('id', $checkToken->id)->update(['phone' => $request->phone]);
            if ($updatePhone) {
                $checkCode = Verification::where('user_id', $checkToken->id)->first();
                if ($checkCode !== null) {
                    Verification::where('user_id', $checkToken->id)->update([
                        'code' => random_int(1000, 9999),
                        'start_time' => Carbon::now()->toTimeString(),
                        'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                        'date' => date('Y-m-d')
                    ]);
                    $getCode = Verification::where('user_id', $checkToken->id)->first();
                    if ($getCode) {
                        $sendMessage = LaravelTwilio::notify($checkToken->phone, 'Your Verification Code : ' . $getCode->code . '
            It will be expire in 15 minutes');
                        if (!$sendMessage) {
                            return response()->json(['alert' => 'Phone number is incorrect'], 404);
                        }
                    }
                } else {
                    Verification::create([
                        'user_id' => $checkToken->id,
                        'code' => random_int(1000, 9999),
                        'start_time' => Carbon::now()->toTimeString(),
                        'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                        'date' => date('Y-m-d')
                    ]);
                    $getCode = Verification::where('user_id', $checkToken->id)->first();
                    if ($getCode) {
                        $sendMessage = LaravelTwilio::notify($checkToken->phone, 'Your Verification Code : ' . $getCode->code . '
            It will be expire in 15 minutes');
                        if (!$sendMessage) {
                            return response()->json(['alert' => 'Phone number is incorrect'], 404);
                        }
                    }
                }
            } else {
                return response()->json(['alert' => 'Cant update phone number'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid token'], 404);
        }
    }
}
