<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
