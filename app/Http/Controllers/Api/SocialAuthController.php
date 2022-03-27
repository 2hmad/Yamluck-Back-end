<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function facebook(Request $request)
    {
        $isUser = Users::where('facebook_id', $request->facebook_id)->first();
        $checkEmail = Users::where('email', $request->email)->first();
        if ($isUser !== null) {
            return Users::where('email', $request->email)->first();
        } else if ($checkEmail !== null) {
            Users::where('email', $request->email)->update([
                "facebook_id" => $request->facebook_id
            ]);
            $getUser = Users::where('email', $request->email)->first();
            Notifications::create([
                'user_id' => $getUser->id,
                'sender' => "Yammluck",
                'subject_en' => "Login Successfully",
                'subject_ar' => "تم تسجيل الدخول بنجاح",
                "content_en" => "Your account has been successfully logged in",
                "content_ar" => "لقد تمت عملية تسجيل دخول لحسابك بنجاح",
                "date" => date('Y-m-d'),
            ]);
            return $getUser;
        } else {
            Users::create([
                "full_name" => $request->full_name,
                "nick_name" => $request->full_name,
                "email" => $request->email,
                "facebook_id" => $request->facebook_id,
                "password" => Hash::make($request->facebook_id),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.png',
                'notifications' => 'Yes',
                'verified' => 0,
                "birthdate" => date("Y-m-d")
            ]);
            $getID = Users::where('email', $request->email)->first();
            DB::table('yamluck')->insert([
                'user_id' => $getID->id,
                'amount' => 0,
            ]);
            Notifications::create([
                'user_id' => $getID->id,
                'sender' => "Yammluck",
                'subject_en' => "Login Successfully",
                'subject_ar' => "تم تسجيل الدخول بنجاح",
                "content_en" => "Your account has been successfully logged in",
                "content_ar" => "لقد تمت عملية تسجيل دخول لحسابك بنجاح",
                "date" => date('Y-m-d'),
            ]);
            return $getID;
        }
    }
    public function google(Request $request)
    {
        $isUser = Users::where('google_id', $request->google_id)->first();
        $checkEmail = Users::where('email', $request->email)->first();
        if ($isUser !== null) {
            return Users::where('email', $request->email)->first();
        } else if ($checkEmail !== null) {
            Users::where('email', $request->email)->update([
                "google_id" => $request->google_id
            ]);
            $getUser = Users::where('email', $request->email)->first();
            Notifications::create([
                'user_id' => $getUser->id,
                'sender' => "Yammluck",
                'subject_en' => "Login Successfully",
                'subject_ar' => "تم تسجيل الدخول بنجاح",
                "content_en" => "Your account has been successfully logged in",
                "content_ar" => "لقد تمت عملية تسجيل دخول لحسابك بنجاح",
                "date" => date('Y-m-d'),
            ]);
            return $getUser;
        } else {
            Users::create([
                "full_name" => $request->full_name,
                "nick_name" => $request->full_name,
                "email" => $request->email,
                "google_id" => $request->google_id,
                "password" => Hash::make($request->google_id),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.png',
                'notifications' => 'Yes',
                'verified' => 0,
                "birthdate" => date("Y-m-d")
            ]);
            $getID = Users::where('email', $request->email)->first();
            DB::table('yamluck')->insert([
                'user_id' => $getID->id,
                'amount' => 0,
            ]);
            Notifications::create([
                'user_id' => $getID->id,
                'sender' => "Yammluck",
                'subject_en' => "Login Successfully",
                'subject_ar' => "تم تسجيل الدخول بنجاح",
                "content_en" => "Your account has been successfully logged in",
                "content_ar" => "لقد تمت عملية تسجيل دخول لحسابك بنجاح",
                "date" => date('Y-m-d'),
            ]);
            return $getID;
        }
    }
}
