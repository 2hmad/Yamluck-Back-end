<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function sendNotify(Request $request)
    {
        $checkNotify = Notifications::where('user_id', $request->uid)
            ->where('subject_en', $request->subject_en)
            ->where('subject_ar', $request->subject_ar)
            ->first();
        if ($checkNotify == null) {
            Notifications::create([
                'user_id' => $request->uid,
                'sender' => $request->sender,
                'subject_en' => $request->subject_en,
                'subject_ar' => $request->subject_ar,
                'content_en' => $request->content_en,
                'content_ar' => $request->content_ar,
                'date' => date('Y-m-d')
            ]);
        } else {
            return response()->json(['alert' => 'Sent before'], 404);
        }
    }
}
