<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OffersController extends Controller
{
    public function randomOffers(Request $request, $limit)
    {
        return Offers::inRandomOrder()->limit($limit)->get();
    }
    public function getOffers($category_id)
    {
        return Offers::where('category_id', $category_id)->get();
    }
    public function getSubOffers($sub_category_id)
    {
        return Offers::where('sub_category_id', $sub_category_id)->get();
    }
    public function getSubSubOffers($sub_sub_category_id)
    {
        return Offers::where('sub_sub_category_id', $sub_sub_category_id)->get();
    }
    public function addOffer(Request $request)
    {
        $validate = $request->validate([
            'pic_one' => 'required|mimes:jpg,png,jpeg|max:2000',
            'pic_two' => 'mimes:jpg,png,jpeg|max:2000',
            'pic_three' => 'mimes:jpg,png,jpeg|max:2000',
        ]);
        if ($validate) {
            $reqDecode = json_decode($request->data, true);
            $checkProduct = Offers::where([
                ['title_en', '=', $reqDecode['title_en']],
                ['title_ar', '=', $reqDecode['title_ar']],
                ['details_en', '=', $reqDecode['details_en']],
                ['details_ar', '=', $reqDecode['details_ar']],
                ['price', '=', $reqDecode['price']],
            ])->first('id');
            if ($checkProduct == null) {
                Offers::create([
                    "title_ar" => $reqDecode['title_ar'],
                    "title_en" => $reqDecode['title_en'],
                    'details_ar' => $reqDecode['details_ar'],
                    'details_en' => $reqDecode['details_en'],
                    'price' => $reqDecode['price'],
                    'share_price' => $reqDecode['price'] / $reqDecode['participants'],
                    'start_date' => $reqDecode['start_date'],
                    'end_date' => $reqDecode['end_date'],
                    'max_subs' => $reqDecode['participants'],
                    'curr_subs' => 0,
                    'conditions_ar' => json_encode($reqDecode['conditions_ar']),
                    'conditions_en' => json_encode($reqDecode['conditions_en']),
                    'category_id' => $reqDecode['category'],
                    'sub_category_id' => $reqDecode['subCategory'],
                    'sub_sub_category_id' => $reqDecode['subSubCategory'],
                    'publish_date' => date('Y-m-d')
                ]);
                $getProduct = Offers::where([
                    ['title_en', '=', $reqDecode['title_en']],
                    ['title_ar', '=', $reqDecode['title_ar']],
                    ['details_en', '=', $reqDecode['details_en']],
                    ['details_ar', '=', $reqDecode['details_ar']],
                    ['price', '=', $reqDecode['price']],
                ])->first('id');
                if ($getProduct && $getProduct !== null) {
                    File::makeDirectory(public_path() . '/storage/products/product_id_' . $getProduct->id);
                    $file_name_one = '1' . '.' . $request->pic_one->getClientOriginalExtension();
                    $file_path_one = $request->file('pic_one')->storeAs('products/product_id_' . $getProduct->id, $file_name_one, 'public');

                    $file_name_two = '2' . '.' . $request->pic_two->getClientOriginalExtension();
                    $file_path_two = $request->file('pic_two')->storeAs('products/product_id_' . $getProduct->id, $file_name_two, 'public');

                    $file_name_three = '3' . '.' . $request->pic_three->getClientOriginalExtension();
                    $file_path_three = $request->file('pic_three')->storeAs('products/product_id_' . $getProduct->id, $file_name_three, 'public');

                    Offers::where([
                        ['title_en', '=', $reqDecode['title_en']],
                        ['title_ar', '=', $reqDecode['title_ar']],
                        ['details_en', '=', $reqDecode['details_en']],
                        ['details_ar', '=', $reqDecode['details_ar']],
                        ['price', '=', $reqDecode['price']],
                    ])->update([
                        'pic_one' => $file_name_one,
                        'pic_two' => $file_name_two,
                        'pic_three' => $file_name_three,
                    ]);
                    return response()->json(['success' => 'Added successfully.']);
                }
            } else {
                return response()->json(['success' => 'Product has been added before'], 404);
            }
        } else {
            return response()->json(['success' => 'MIMES Invalid.'], 404);
        }
    }
}
