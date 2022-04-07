<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    public function bulkMessage(Request $request)
    {
        if ($request->method == 'Notification') {
            $checkNotify = Notifications::where('user_id', $request->uid)
                ->where('subject_en', $request->subject_en)
                ->where('subject_ar', $request->subject_ar)
                ->first();
            if ($checkNotify == null) {
                Notifications::create([
                    'user_id' => "All",
                    'sender' => "Yammluck",
                    'subject_en' => $request->subject_en,
                    'subject_ar' => $request->subject_ar,
                    'content_en' => $request->content_en,
                    'content_ar' => $request->content_ar,
                    'date' => date('Y-m-d')
                ]);
            } else {
                return response()->json(['alert' => 'Sent before'], 404);
            }
        } else if ($request->method == 'Email') {
            $getEmail = Users::get('email');
            $body = $request->content_en;
            $subject = $request->subject_en;
            foreach ($getEmail as $email) {
                Mail::send([], [], function ($message) use ($email, $body, $subject) {
                    $message->to($email)->subject($subject)->setBody($body);
                });
            }
        }
    }
}
