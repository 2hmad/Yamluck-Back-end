<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function get()
    {
        return DB::table('ads')->orderBy('id', 'DESC')->first();
    }
    public function addAd(Request $request)
    {
        $validate = $request->validate([
            'banner' => 'required|mimes:jpg,png,jpeg|max:2000',
        ]);
        if ($validate) {
            $reqDecode = json_decode($request->data, true);
            $banner_name = 'ad' . '.' . $request->banner->getClientOriginalExtension();
            $banner_path = $request->file('banner')->storeAs('ads', $banner_name, 'public');

            DB::table('ads')->update([
                'redirect' => $reqDecode['product_id'],
                'banner' => $banner_name
            ]);
            return response()->json(['success' => 'Ad Added successfully.']);
        } else {
            return response()->json(['success' => 'MIMES Invalid.'], 404);
        }
    }
}
