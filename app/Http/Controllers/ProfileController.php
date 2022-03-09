<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\DB;
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
            Users::where('token', $headerToken)->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => str_replace(' ', '', $request->phone),
                'birthdate' => $request->birthdate,
                'country' => $request->country
            ]);
            if (str_replace(' ', '', $request->phone) !== $checkToken->phone) {
                Users::where('token', $headerToken)->update([
                    'verified' => 0
                ]);
                DB::table('phone_verified')->where('user_id', $checkToken->id)->delete();
                Verification::create([
                    'user_id' => $checkToken->id,
                    'code' => random_int(1000, 9999),
                    'start_time' => Carbon::now()->toTimeString(),
                    'end_time' => Carbon::now()->addMinutes(15)->toTimeString(),
                    'date' => date('Y-m-d')
                ]);
            }
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
            $validate = $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png|max:2000'
            ]);
            if ($validate) {
                $file_name = 'uid' . '_' . $checkToken->id . '.' . $request->file->getClientOriginalExtension();
                $file_path = $request->file('file')->storeAs('users', $file_name, 'public');
                return Users::where('token', $headerToken)->update([
                    'pic' => $file_name
                ]);
                return response()->json(['success' => 'File uploaded successfully.']);
            } else {
                return response()->json(['alert' => 'Invalid MIME Type'], 404);
            }
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
