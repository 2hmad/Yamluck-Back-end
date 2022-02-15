<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $checkUser = DB::table('users')->where([
            'email' => $request->email,
            'password' => Hash::check($request->password, Hash::make($request->password))
        ])->first();
        dd($checkUser);
        if ($checkUser !== "") {
            return Users::where('email', $request->email)->get('token');
        } else {
            return response('User not found', 404);
        }
    }
    public function social(Request $request, $service)
    {
        if ($service == "facebook") {
        }
    }
}
