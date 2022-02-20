<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
            return Users::where('token', $request->token)->first();
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function editProfile(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
            return Users::where('token', $request->token)->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function changePic(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function changePassword(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
            $checkOld = Users::where('token', $request->token)->first('password');
            if (Hash::check($request->oldPassword, $checkOld->password)) {
                return Users::where('token', $request->token)->update([
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
