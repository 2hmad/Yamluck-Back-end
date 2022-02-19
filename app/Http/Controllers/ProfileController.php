<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $checkToken = Users::where('token', $request->token)->first();
        if ($checkToken !== null && $request->token !== null) {
            return Users::where('token', $request->token)->first();
        } else {
            return response()->json(['alert' => 'token-invalid'], 404);
        }
    }
}
