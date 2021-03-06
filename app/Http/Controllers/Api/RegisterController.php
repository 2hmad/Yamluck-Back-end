<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgesRepeat;
use App\Models\CountryRepeat;
use App\Models\PhoneVerified;
use App\Models\Users;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Dot2hmad\LaravelTwilio\Facades\LaravelTwilio;
use Illuminate\Support\Facades\DB;

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
                    'phone' => str_replace(' ', '', $request->phone),
                    'country' => $request->country,
                    'city' => $request->city,
                    'nationality' => $request->country,
                    'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d'),
                    'interest' => $request->interest,
                    'password' => Hash::make($request->password),
                    'token' => md5(rand(1, 10) . microtime()),
                    'pic' => 'default.png',
                    'notifications' => 'Yes',
                    'verified' => 0,
                ]);
                if ($createUser) {
                    $getID = Users::where('email', $request->email)->first();
                    $checkCountry = CountryRepeat::where('country', $getID->country)->first();
                    if ($checkCountry !== null) {
                        CountryRepeat::where('country', $getID->country)->update([
                            'country' => $getID->country,
                            'repeat' => $checkCountry->repeat + 1
                        ]);
                    } else {
                        CountryRepeat::insert([
                            'country' => $getID->country,
                            'repeat' => 1
                        ]);
                    }

                    $yearFromBirthdate = Carbon::createFromFormat('Y-m-d', $getID->birthdate)->year;
                    $checkYear = AgesRepeat::where('year', $yearFromBirthdate)->first();
                    if ($checkYear !== null) {
                        AgesRepeat::where('year', $yearFromBirthdate)->update([
                            'year' => $yearFromBirthdate,
                            'repeat' => $checkYear->repeat + 1
                        ]);
                    } else {
                        AgesRepeat::insert([
                            'year' => $yearFromBirthdate,
                            'repeat' => 1
                        ]);
                    }
                    $checkCode = Verification::where('user_id', $getID->id)->first();
                    if ($checkCode !== null) {
                        Verification::where('user_id', $getID->id)->update([
                            'code' => random_int(1000, 9999),
                            'start_time' => Carbon::now()->toTimeString(),
                            'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                            'date' => date('Y-m-d')
                        ]);
                        DB::table('yamluck')->insert([
                            'user_id' => $getID->id,
                            'amount' => 0,
                        ]);
                        $getCode = Verification::where('user_id', $getID->id)->first();
                        if ($getCode) {
                            $sendMessage = LaravelTwilio::notify($getID->phone, 'Your Verification Code : ' . $getCode->code . '
It will be expire in 15 minutes');
                            if (!$sendMessage) {
                                return response()->json(['alert' => 'Phone number is incorrect'], 404);
                            }
                        }
                    } else {
                        Verification::create([
                            'user_id' => $getID->id,
                            'code' => random_int(1000, 9999),
                            'start_time' => Carbon::now()->toTimeString(),
                            'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                            'date' => date('Y-m-d')
                        ]);
                        DB::table('yamluck')->insert([
                            'user_id' => $getID->id,
                            'amount' => 0,
                        ]);
                        $getCode = Verification::where('user_id', $getID->id)->first();
                        if ($getCode) {
                            $sendMessage = LaravelTwilio::notify($getID->phone, 'Your Verification Code : ' . $getCode->code . '
It will be expire in 15 minutes');
                            if (!$sendMessage) {
                                return response()->json(['alert' => 'Phone number is incorrect'], 404);
                            }
                        }
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
}
