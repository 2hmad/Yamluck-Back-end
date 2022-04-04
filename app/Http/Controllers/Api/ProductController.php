<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($id)
    {
        $get = Offers::where('id', $id)->with('country')->with('city')->first();
        if ($get == "") {
            return response()->json(['alert' => 'Invalid Offer ID'], 404);
        } else {
            return $get;
        }
    }
    public function getSimilarProduct($id)
    {
        $getName = Offers::where('id', $id)->pluck('title_en')->first();
        if ($getName !== "") {
            return Offers::where('title_en', 'like', '%' . $getName . '%')->whereNotIn('id', [$id])->get();
        } else {
            return response()->json(['alert' => 'Invalid User ID'], 404);
        }
    }
}
