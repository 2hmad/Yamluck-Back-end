<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\Offers;
use App\Models\Subscribe;
use App\Models\Users;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'pic_four' => 'mimes:jpg,png,jpeg|max:2000',
            'pic_five' => 'mimes:jpg,png,jpeg|max:2000',
            'pic_six' => 'mimes:jpg,png,jpeg|max:2000',
        ]);
        if ($validate) {
            $reqDecode = json_decode($request->data, true);
            $checkProduct = Offers::where([
                ['title_en', '=', $reqDecode['title_en']],
                ['title_ar', '=', $reqDecode['title_ar']],
                ['owner_name', '=', $reqDecode['owner_name']],
                ['owner_phone', '=', $reqDecode['owner_phone']],
                ['details_en', '=', $reqDecode['details_en']],
                ['details_ar', '=', $reqDecode['details_ar']],
                ['price', '=', $reqDecode['price']],
            ])->first('id');
            if ($checkProduct == null) {
                Offers::create([
                    "title_ar" => $reqDecode['title_ar'],
                    "title_en" => $reqDecode['title_en'],
                    "owner_name" => $reqDecode['owner_name'],
                    "owner_phone" => $reqDecode['owner_phone'],
                    'details_ar' => $reqDecode['details_ar'],
                    'details_en' => $reqDecode['details_en'],
                    'price' => $reqDecode['price'],
                    'share_price' => $reqDecode['price'] / $reqDecode['participants'],
                    'start_date' => $reqDecode['start_date'],
                    'end_date' => $reqDecode['end_date'],
                    'max_subs' => $reqDecode['participants'],
                    'curr_subs' => 0,
                    'conditions_ar' => $reqDecode['conditions_ar'],
                    'conditions_en' => $reqDecode['conditions_en'],
                    'category_id' => $reqDecode['category'],
                    'sub_category_id' => $reqDecode['subCategory'],
                    'sub_sub_category_id' => $reqDecode['subSubCategory'],
                    'country' => $reqDecode['country'],
                    'city' => $reqDecode['city'],
                    'video_link' => $reqDecode['video_link'],
                    'publish_date' => date('Y-m-d')
                ]);
                $getProduct = Offers::where([
                    ['title_en', '=', $reqDecode['title_en']],
                    ['title_ar', '=', $reqDecode['title_ar']],
                    ['owner_name', '=', $reqDecode['owner_name']],
                    ['owner_phone', '=', $reqDecode['owner_phone']],
                    ['details_en', '=', $reqDecode['details_en']],
                    ['details_ar', '=', $reqDecode['details_ar']],
                    ['price', '=', $reqDecode['price']],
                ])->first('id');
                if ($getProduct && $getProduct !== null) {
                    $getInterestUsers = Users::where('interest', $reqDecode['category'])->get();
                    if ($getInterestUsers == null) {
                        foreach ($getInterestUsers as $interestUser) {
                            Notifications::create([
                                'user_id' => $interestUser->id,
                                'sender' => "Yammluck",
                                'subject_en' => "Offers you may be interested in",
                                'subject_ar' => "عروض قد تهمك",
                                "content_en" => $reqDecode['title_en'] . " has been posted to your interests, you may be interested",
                                "content_ar" => "لقد تم نشر " . $reqDecode['title_ar'] . ' في نفس اهتماماتك ، قد يهمك',
                                "date" => date('Y-m-d'),
                            ]);
                        }
                    }
                    File::makeDirectory(public_path() . '/storage/products/product_id_' . $getProduct->id);
                    $file_name_one = '1' . '.' . $request->pic_one->getClientOriginalExtension();
                    $file_path_one = $request->file('pic_one')->storeAs('products/product_id_' . $getProduct->id, $file_name_one, 'public');

                    $file_name_two = '2' . '.' . $request->pic_two->getClientOriginalExtension();
                    $file_path_two = $request->file('pic_two')->storeAs('products/product_id_' . $getProduct->id, $file_name_two, 'public');

                    $file_name_three = '3' . '.' . $request->pic_three->getClientOriginalExtension();
                    $file_path_three = $request->file('pic_three')->storeAs('products/product_id_' . $getProduct->id, $file_name_three, 'public');

                    $file_name_four = '4' . '.' . $request->pic_four->getClientOriginalExtension();
                    $file_path_four = $request->file('pic_four')->storeAs('products/product_id_' . $getProduct->id, $file_name_four, 'public');

                    $file_name_five = '5' . '.' . $request->pic_five->getClientOriginalExtension();
                    $file_path_five = $request->file('pic_five')->storeAs('products/product_id_' . $getProduct->id, $file_name_five, 'public');

                    $file_name_six = '6' . '.' . $request->pic_six->getClientOriginalExtension();
                    $file_path_six = $request->file('pic_six')->storeAs('products/product_id_' . $getProduct->id, $file_name_six, 'public');

                    Offers::where([
                        ['title_en', '=', $reqDecode['title_en']],
                        ['title_ar', '=', $reqDecode['title_ar']],
                        ['owner_name', '=', $reqDecode['owner_name']],
                        ['owner_phone', '=', $reqDecode['owner_phone']],
                        ['details_en', '=', $reqDecode['details_en']],
                        ['details_ar', '=', $reqDecode['details_ar']],
                        ['price', '=', $reqDecode['price']],
                    ])->update([
                        'pic_one' => $file_name_one,
                        'pic_two' => $file_name_two,
                        'pic_three' => $file_name_three,
                        'pic_four' => $file_name_four,
                        'pic_five' => $file_name_five,
                        'pic_six' => $file_name_six,
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
