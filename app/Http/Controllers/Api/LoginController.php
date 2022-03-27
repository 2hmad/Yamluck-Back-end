<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $checkUser = Users::where('email', '=', $request->email)->first();
        if ($checkUser) {
            if (Hash::check($request->password, $checkUser->password)) {
                $getToken = Users::where('email', $request->email)->first(['id', 'phone', 'token', 'verified']);
                $getNotification = Notifications::where([
                    ['user_id', '=', $getToken->id],
                    ['subject_en', '=', 'Login Successfully'],
                    ['date', '=', date('Y-m-d')]
                ])->first();
                if ($getNotification == null) {
                    Notifications::create([
                        'user_id' => $getToken->id,
                        'sender' => "Yammluck",
                        'subject_en' => "Login Successfully",
                        'subject_ar' => "تم تسجيل الدخول بنجاح",
                        "content_en" => "Your account has been successfully logged in",
                        "content_ar" => "لقد تمت عملية تسجيل دخول لحسابك بنجاح",
                        "date" => date('Y-m-d'),
                    ]);
                }
                return $getToken;
            } else {
                return response()->json(['alert' => 'Wrong Password'], 404);
            }
        } else {
            return response()->json(['alert' => 'User not found'], 404);
        }
    }
}
