<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null || $headerToken !== null) {
            return Users::where('token', $headerToken)->first();
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function editProfile(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            return Users::where('token', $headerToken)->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            return response()->json(['alert' => 'OK'], 200);
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function changePic(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function changePassword(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $checkOld = Users::where('token', $headerToken)->first('password');
            if (Hash::check($request->oldPassword, $checkOld->password)) {
                return Users::where('token', $headerToken)->update([
                    'password' => Hash::make($request->newPassword)
                ]);
            } else {
                return response()->json(['alert' => 'The old password is not correct'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
