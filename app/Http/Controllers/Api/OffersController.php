<?php

namespace App\Http\Controllers\Api;

use App\Models\Offers;
use Illuminate\Http\Request;

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
}
