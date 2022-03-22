<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Verification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dot2hmad\LaravelTwilio\Facades\LaravelTwilio;

class VerificationController extends Controller
{
    public function resend(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $getID = Users::where('token', $headerToken)->first();
        $checkCode = Verification::where('user_id', $getID->id)->first();
        if ($checkCode !== null) {
            Verification::where('user_id', $getID->id)->update([
                'code' => random_int(1000, 9999),
                'start_time' => Carbon::now()->toTimeString(),
                'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                'date' => date('Y-m-d')
            ]);
            $getCode = Verification::where('user_id', $getID->id)->first();
            if ($getCode) {
                return LaravelTwilio::notify($getID->phone, 'Your Verification Code : ' . $getCode->code . '
It will be expire in 15 minutes');
            }
        } else {
            Verification::create([
                'user_id' => $getID->id,
                'code' => random_int(1000, 9999),
                'start_time' => Carbon::now()->toTimeString(),
                'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                'date' => date('Y-m-d')
            ]);
            $getCode = Verification::where('user_id', $getID->id)->first();
            if ($getCode) {
                LaravelTwilio::notify($getID->phone, 'Your Verification Code : ' . $getCode->code . '
It will be expire in 15 minutes');
            }
        }
    }
    public function verify(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $getID = Users::where('token', $headerToken)->first();
        $checkCode = DB::table('verification')->where('code', '=', $request->code)->where('user_id', '=', $getID->id)->first();
        if ($checkCode !== null && $checkCode->date == date('Y-m-d') && $checkCode->end_time >= Carbon::now()->toTimeString()) {
            $delVerify = Verification::where('user_id', $getID->id)->delete();
            $updateVerified = Users::where('id', $getID->id)->update([
                'verified' => 1
            ]);
            $insertVerified = DB::table('phone_verified')->insert([
                'user_id' => $getID->id
            ]);
            if ($delVerify && $updateVerified && $insertVerified) {
                return response()->json(['alert' => 'OK'], 200);
            }
        } else {
            return response()->json(['alert' => 'Invalid Code'], 404);
        }
    }
}
