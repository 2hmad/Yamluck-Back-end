<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $checkEmail = Users::where('email', $request->email)->first();
        if (!$checkEmail) {
            $createUser = Users::create([
                'full_name' => $request->full_name,
                'nick_name' => $request->nick_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'city' => $request->city,
                'age' => $request->age,
                'interest' => $request->interest,
                'password' => Hash::make($request->password),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.jpg',
                'notification' => 'Yes'
            ]);
            if ($createUser) {
                return response('successfully', 200);
            }
        } else {
            return response('registered already', 404);
        }
    }
    public function facebookRedirect()
    {
        return Socialite::driver("facebook")->stateless()->redirect();
    }
    public function facebookCallback()
    {
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
                'notification' => 'Yes'
            ]);
            return redirect('/dashboard');
        }
    }
    public function twitterRedirect()
    {
        return Socialite::driver("twitter")->stateless()->redirect();
    }
    public function twitterCallback()
    {
        $user = Socialite::driver("twitter")->stateless()->user();
        $isUser = Users::where('twitter_id', $user->id)->first();
        $checkEmail = Users::where('email', $user->email)->first();
        if ($isUser) {
            return redirect('/dashboard');
        } elseif ($checkEmail) {
            $createUser = Users::where('email', $user->email)->update([
                'twitter_id' => $user->id
            ]);
            return redirect('/dashboard');
        } else {
            $createUser = Users::create([
                'full_name' => $user->name,
                'nick_name' => $user->nickname,
                'email' => $user->email,
                'twitter_id' => $user->id,
                'password' => Hash::make(Str::random(8)),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.jpg',
                'notifications' => 'Yes'
            ]);
            return redirect('/dashboard');
        }
    }
}
