<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($id)
    {
        $get = Offers::where('id', $id)->first()->toJson();
        if ($get == "") {
            return response('Invalid ID', 400);
        } else {
            return $get;
        }
    }
    public function getSimilarProduct($id)
    {
        $getName = Offers::where('id', $id)->pluck('title_en')->first();
        if ($getName !== "") {
            return Offers::where('title_en', 'like', '%' . $getName . '%')->whereNotIn('id', [$id])->get(['id', 'pic_one', 'title_en', 'title_ar', 'price']);
        } else {
            return response('Invalid ID', 400);
        }
    }
}
