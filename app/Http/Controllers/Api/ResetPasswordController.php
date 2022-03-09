<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $email = $request->email;
        $checkUser = Users::where('email', '=', $email)->first();
        if ($checkUser !== null) {
            $check = DB::table('reset_password')->where('u_email', '=', $email)->first();
            if ($check == null) {
                return DB::table('reset_password')->insert([
                    'u_email' => $email,
                    'code' => Str::random(25),
                    'date' => date('Y-m-d')
                ]);
            } else {
                return DB::table('reset_password')->where('u_email', '=', $email)->update([
                    'u_email' => $email,
                    'code' => Str::random(25),
                    'date' => date('Y-m-d')
                ]);
            }
        } else {
            return response()->json(['alert' => 'User not found'], 404);
        }
    }
    public function update(Request $request, $code)
    {
        $getUserEmail = DB::table('reset_password')->where('code', '=', $code)->first();
        if ($getUserEmail !== null) {
            $updatePassword = Users::where('email', $getUserEmail->u_email)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            if ($updatePassword) {
                return DB::table('reset_password')->where('code', '=', $code)->delete();
            }
        } else {
            return response()->json(['alert' => 'Invalid Code'], 404);
        }
    }
}
