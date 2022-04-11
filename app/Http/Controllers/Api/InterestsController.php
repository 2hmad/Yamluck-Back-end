<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class InterestsController extends Controller
{
    public function get(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            return $checkToken->interest;
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
    public function update(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            Users::where('token', $headerToken)->update([
                'interest' => $request->interest
            ]);
        } else {
            return response()->json(['alert' => 'Invalid Token'], 404);
        }
    }
}
