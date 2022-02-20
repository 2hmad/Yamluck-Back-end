<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use stdClass;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $checkUser = Users::where('email', '=', $request->email)->first();
        if ($checkUser) {
            if (Hash::check($request->password, $checkUser->password)) {
                $getToken = Users::where('email', $request->email)->first('token');
                return $getToken;
            } else {
                return response()->json(['alert' => 'Wrong Password'], 404);
            }
        } else {
            return response()->json(['alert' => 'User not found'], 404);
        }
    }
    public function social(Request $request, $service)
    {
        if ($service == "facebook") {
            return Socialite::driver("facebook")->stateless()->redirect();
            $user = Socialite::driver("facebook")->stateless()->user();
            $isUser = Users::where('facebook_id', $user->id)->first();
            $checkEmail = Users::where('email', $user->email)->first();
            if ($isUser) {
                return redirect('/dashboard');
            } elseif ($checkEmail) {
                $createUser = Users::where('email', $user->email)->update([
                    'facebook_id' => $user->id
                ]);
                return redirect('/dashboard');
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
                return redirect('/dashboard');
            }
        }
    }
}
