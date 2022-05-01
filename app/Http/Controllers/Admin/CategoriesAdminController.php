<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesAdminController extends Controller
{
    public function index()
    {
        return DB::table('categories')->get();
    }
    public function delete(Request $request)
    {
        return DB::table('categories')->where('id', '=', $request->id)->delete();
    }
    public function update(Request $request)
    {
        return DB::table('categories')->where('id', '=', $request->id)->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar
        ]);
    }
    public function getSubCat(Request $request)
    {
        return DB::table('sub_categories')->where('category_id', '=', $request->catId)->get();
    }
    public function deleteSubCat(Request $request)
    {
        return DB::table('sub_categories')->where('id', '=', $request->id)->delete();
    }
    public function updateSubCat(Request $request)
    {
        return DB::table('sub_categories')->where('id', '=', $request->id)->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar
        ]);
    }
    public function getSubSubCat(Request $request)
    {
        return DB::table('sub_sub_category')->where('sub_category_id', '=', $request->subCatId)->get();
    }
    public function deleteSubSubCat(Request $request)
    {
        return DB::table('sub_sub_category')->where('id', '=', $request->id)->delete();
    }
    public function updateSubSubCat(Request $request)
    {
        return DB::table('sub_sub_category')->where('id', '=', $request->id)->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar
        ]);
    }
}
