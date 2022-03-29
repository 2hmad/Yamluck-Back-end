<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeSettingsController extends Controller
{
    public function addCarousel(Request $request)
    {
        $validate = $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg|max:2000'
        ]);
        if ($validate) {
            $reqDecode = json_decode($request->data, true);
            $file_name = $reqDecode['heading_en'] . '.' . $request->image->getClientOriginalExtension();
            $file_path = $request->file('image')->storeAs('carousels', $file_name, 'public');
            DB::table('home_settings')->insert([
                'heading_en' => $reqDecode['heading_en'],
                'heading_ar' => $reqDecode['heading_ar'],
                'sub_heading_en' => $reqDecode['subHeading_en'],
                'sub_heading_ar' => $reqDecode['subHeading_ar'],
                'content_en' => $reqDecode['content_en'],
                'content_ar' => $reqDecode['content_ar'],
                'btn_text_en' => $reqDecode['btn_text_en'],
                'btn_text_ar' => $reqDecode['btn_text_ar'],
                'btn_redirect' => $reqDecode['btn_redirect'],
                'image' => $file_name,
            ]);
            return response()->json(['alert' => 'Success'], 200);
        } else {
            return response()->json(['alert' => 'Invalid MIME Type'], 404);
        }
    }
    public function deleteCarousel(Request $request)
    {
        DB::table('home_settings')->where('id', '=', $request->id)->delete();
    }
}
