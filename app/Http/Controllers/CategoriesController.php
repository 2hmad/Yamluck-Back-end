<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        return DB::table('categories')->get()->toJson();
    }
    public function getCategoriesLimit($count)
    {
        return DB::table('categories')->limit($count)->get();
    }
    public function getSubCategories($cat_id)
    {
        if ($cat_id == null) {
            return response('ID Invalid', 404);
        } else {
            return DB::table('sub_categories')->where('category_id', '=', $cat_id)->get()->toJson();
        }
    }
    public function getSubSubCategories($subcat_id)
    {
        if ($subcat_id == null) {
            return response('ID Invalid', 404);
        } else {
            return DB::table('sub_sub_category')->where('sub_category_id', '=', $subcat_id)->get()->toJson();
        }
    }
}
