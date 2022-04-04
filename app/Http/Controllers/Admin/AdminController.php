<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->email !== '' && $request->password !== '') {
            $checkUser = DB::table('admins')->where('email', '=', $request->email)->first();
            if ($checkUser !== null) {
                $checkCredentials = DB::table('admins')->where('email', '=', $request->email)->where('password', '=', Hash::check($checkUser->password, $request->password))->first();
                if ($checkCredentials !== null) {
                    return $checkCredentials;
                } else {
                    return response()->json(['alert' => 'Email / Password is Incorrect'], 404);
                }
            } else {
                return response()->json(['alert' => 'User not found'], 404);
            }
        } else {
            return response()->json(['alert' => 'Fields not completed'], 404);
        }
    }
    public function addAdmin(Request $request)
    {
        if ($request->name !== '' && $request->email !== '' && $request->password !== '') {
            $checkEmail = DB::table('admins')->where('email', $request->email)->first();
            if ($checkEmail == null) {
                DB::table('admins')->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'permissions' => 1,
                    'token' => md5(rand(1, 10) . microtime())
                ]);
            } else {
                return response()->json(['alert' => 'Admin has been added before'], 404);
            }
        } else {
            return response()->json(['alert' => 'Information not complete'], 404);
        }
    }
    public function deleteAdmin(Request $request)
    {
        if ($request->email !== '') {
            DB::table('admins')->where('email', '=', $request->email)->delete();
        } else {
            return response()->json(['alert' => 'Email not found'], 404);
        }
    }
    public function admins()
    {
        return DB::table('admins')->get();
    }
    public function change_password(Request $request)
    {
        $getAdmin = DB::table('admins')->where('token', $request->header('token'))->first();
        if (Hash::check($request->oldPassword, $getAdmin->password)) {
            DB::table('admins')->where('token', $request->header('token'))->update([
                'password' => Hash::make($request->newPassword)
            ]);
        } else {
            return response()->json(['alert' => 'The old password is not correct'], 404);
        }
    }
}
