<?php

namespace App\Http\Controllers\Api;

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
                $getToken = Users::where('email', $request->email)->first(['id', 'token']);
                return $getToken;
            } else {
                return response()->json(['alert' => 'Wrong Password'], 404);
            }
        } else {
            return response()->json(['alert' => 'User not found'], 404);
        }
    }
    public function facebookRedirect()
    {
        return Socialite::driver("facebook")->redirect();
    }
    public function facebookCallback()
    {
        $user = Socialite::driver("facebook")->user();
        $isUser = Users::where('facebook_id', $user->id)->first();
        $checkEmail = Users::where('email', $user->email)->first();
        if ($isUser !== null) {
            return response()->json(['alert' => 'User is found'], 200);
        } elseif ($checkEmail !== null) {
            $createUser = Users::where('email', $user->email)->update([
                'facebook_id' => $user->id
            ]);
        } else {
            $createUser = Users::create([
                'full_name' => $user->name,
                'nick_name' => $user->nickname,
                'email' => $user->email,
                'facebook_id' => $user->id,
                'password' => Hash::make(Str::random(8)),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.jpg',
                'notifications' => 'Yes'
            ]);
            if ($createUser) {
                return response()->json(['alert' => 'User created'], 200);
            }
        }
    }
}
