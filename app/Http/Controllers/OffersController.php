<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function randomOffers(Request $request, $limit)
    {
        return Offers::inRandomOrder()->limit($limit)->get()->toJson();
    }
    public function getOffers($category_id)
    {
        return Offers::where('category_id', $category_id)->get()->toJson();
    }
}
