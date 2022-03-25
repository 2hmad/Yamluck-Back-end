<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Offers;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OffersAdminController extends Controller
{
    public function index()
    {
        return Offers::get();
    }
    public function getSubs(Request $request)
    {
        return Subscribe::where('product_id', $request->product_id)->with('user')->get();
    }
    public function updateOffer(Request $request)
    {
        return Offers::where('id', $request->product_id)->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'details_en' => $request->details_en,
            'details_ar' => $request->details_ar,
        ]);
    }
    public function finishOffer(Request $request)
    {
        $checkWinner = DB::table('winners')->where('product_id', $request->product_id)->first();
        if ($checkWinner == null) {
            $getWinner = Subscribe::where('product_id', $request->product_id)->inRandomOrder()->first();
            if ($getWinner) {
                DB::table('winners')->insert([
                    'user_id' => $getWinner->user_id,
                    'product_id' => $request->product_id,
                    'date' => date('Y-m-d')
                ]);
                $getOffer = Offers::where('id', $request->product_id)->first();
                Notifications::create([
                    'user_id' => $getWinner->user_id,
                    'sender' => "Yammluck",
                    'subject_en' => "Congratulations!",
                    'subject_ar' => "تهانينا!",
                    "content_en" => "You have been chosen to win an (" . $getOffer->title_en . "), please confirm receipt by entering the product and emailing the administration",
                    "content_ar" => "لقد تم اختيارك للفوز بـ (" . $getOffer->title_ar . ") ، برجاء تأكيد الاستلام عن طريق الدخول الي المنتج ومراسلة الادارة",
                    "date" => date('Y-m-d'),
                ]);
            }
        } else {
            return response()->json(['alert' => 'Winner has added before'], 404);
        }
    }
}
