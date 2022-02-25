<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerified;
use App\Models\Users;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $checkEmail = Users::where('email', $request->email)->first();
        $checkPhone = Users::where('phone', $request->phone)->first();
        if (!$checkEmail) {
            if (!$checkPhone) {
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
                    'notifications' => 'Yes',
                    'verified' => 0
                ]);
                if ($createUser) {
                    $getID = Users::where('email', $request->email)->pluck('id')->first();
                    $checkCode = Verification::where('user_id', $getID)->first();
                    if ($checkCode !== null) {
                        Verification::where('user_id', $getID)->update([
                            'code' => random_int(1000, 9999),
                            'start_time' => Carbon::now()->toTimeString(),
                            'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                            'date' => date('Y-m-d')
                        ]);
                    } else {
                        Verification::create([
                            'user_id' => $getID,
                            'code' => random_int(1000, 9999),
                            'start_time' => Carbon::now()->toTimeString(),
                            'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                            'date' => date('Y-m-d')
                        ]);
                    }
                    return response()->json(['alert' => 'Account Created Successfully'], 202);
                }
            } else {
                return response()->json(['alert' => 'The phone number has already been used'], 404);
            }
        } else {
            return response()->json(['alert' => 'The email address has already been used'], 404);
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
            return redirect()->back();
        } elseif ($checkEmail) {
            $createUser = Users::where('email', $user->email)->update([
                'facebook_id' => $user->id
            ]);
            $getToken = Users::where('email', $user->email)->first('token');
            return redirect()->back()->with($getToken);
        } else {
            $createUser = Users::create([
                'full_name' => $user->name,
                'nick_name' => $user->nickname,
                'email' => $user->email,
                'facebook_id' => $user->id,
                'password' => Hash::make(Str::random(8)),
                'token' => md5(rand(1, 10) . microtime()),
                'pic' => 'default.jpg',
                'notifications' => 'Yes',
                'verified' => 0
            ]);
            $getToken = Users::where('email', $user->email)->first('token');
            return redirect()->back()->with($getToken);
        }
    }

    public function twitterRedirect()
    {
        return Socialite::driver("twitter")->redirect();
    }
    public function twitterCallback()
    {
        $user = Socialite::driver("twitter")->user();
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
                'notifications' => 'Yes',
                'verified' => 0
            ]);
            return redirect('/dashboard');
        }
    }
}
