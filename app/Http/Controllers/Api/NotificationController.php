<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function switch(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null && $request->status !== "") {
            if ($request->status == 0) {
                Users::where('id', $checkToken->id)->update([
                    "notifications" => "No"
                ]);
            } else {
                Users::where('id', $checkToken->id)->update([
                    "notifications" => "Yes"
                ]);
            }
        } else {
            return response()->json(['alert' => 'Invalid token'], 404);
        }
    }
    public function fetch(Request $request)
    {
        $headerToken = $request->header('Authorization');
        $checkToken = Users::where('token', $headerToken)->first();
        if ($checkToken !== null && $headerToken !== null) {
            $get = Notifications::where('user_id', $checkToken->id)->get();
            if ($get) {
                return $get;
            } else {
                return response()->json(['alert' => 'Cant get notifications'], 404);
            }
        } else {
            return response()->json(['alert' => 'Invalid token'], 404);
        }
    }
}
