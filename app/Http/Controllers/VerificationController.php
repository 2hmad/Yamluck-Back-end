<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Verification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function resend(Request $request)
    {
        $getID = Users::where('phone', $request->phone)->first('id');
        $checkCode = Verification::where('user_id', $getID->id)->first();
        if ($checkCode !== null) {
            Verification::where('user_id', $getID->id)->update([
                'code' => Str::random(4),
                'start_time' => Carbon::now()->toTimeString(),
                'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                'date' => date('Y-m-d')
            ]);
        } else {
            Verification::create([
                'user_id' => $getID->id,
                'code' => Str::random(4),
                'start_time' => Carbon::now()->toTimeString(),
                'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                'date' => date('Y-m-d')
            ]);
        }
    }
    public function verify(Request $request)
    {
        $getID = Users::where('phone', $request->phone)->first('id');
        $checkCode = DB::table('verification')->where('code', '=', $request->code)->where('user_id', '=', $getID->id)->first();
        if ($checkCode !== null) {
            return DB::table('phone_verified')->insert([
                'user_id' => $getID->id
            ]);
            return Verification::where('user_id', $getID->id)->delete();
        } else {
            return response()->json(['alert' => 'Invalid Code'], 404);
        }
    }
}
