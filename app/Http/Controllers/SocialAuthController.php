<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            return Users::where('email', $request->email)->first();
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
                'verified' => 1,
                "birthdate" => date("Y-m-d")
            ]);
            $getID = Users::where('email', $request->email)->first();
            DB::table('yamluck')->insert([
                'user_id' => $getID->id,
                'amount' => 0,
            ]);
            return $getID;
        }
    }
}
