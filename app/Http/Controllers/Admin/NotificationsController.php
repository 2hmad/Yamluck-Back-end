<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{
    public function sendNotify(Request $request)
    {
        Notifications::create([
            'user_id' => $request->uid,
            'sender' => $request->sender,
            'subject_en' => $request->subject_en,
            'subject_ar' => $request->subject_ar,
            'content_en' => $request->content_en,
            'content_ar' => $request->content_ar,
            "date" => Carbon::now()->toDateTimeString(),
        ]);
    }
    public function bulkMessage(Request $request)
    {
        if ($request->method == 'Notification') {
            Notifications::create([
                'user_id' => "All",
                'sender' => "Yammluck",
                'subject_en' => $request->subject_en,
                'subject_ar' => $request->subject_ar,
                'content_en' => $request->content_en,
                'content_ar' => $request->content_ar,
                "date" => Carbon::now()->toDateTimeString(),
            ]);
        } else if ($request->method == 'Email') {
            $users = Users::get();
            $body = $request->content_en;
            $subject = $request->subject_en;
            foreach ($users as $user) {
                $email = $user->email;
                Mail::send([], [], function ($message) use ($email, $body, $subject) {
                    $message->to($email)->subject($subject)->setBody($body);
                });
            }
        }
    }
}
