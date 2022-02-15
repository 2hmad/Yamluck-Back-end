<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct($id)
    {
        if ($id == null) {
            return response('Product not found', 404);
        } else {
            $get = Offers::where('id', $id)->get()->toJson();
            if ($get !== "") {
                return response('Invalid ID', 400);
            }
        }
    }
}
