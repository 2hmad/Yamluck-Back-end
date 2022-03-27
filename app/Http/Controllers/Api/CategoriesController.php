<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        return DB::table('categories')->get();
    }
    public function getCategoriesLimit($count)
    {
        return DB::table('categories')->limit($count)->get();
    }
    public function getSubCategories($cat_id)
    {
        if ($cat_id == null) {
            return response()->json(['alert' => 'Invalid Cat ID'], 404);
        } else {
            return DB::table('sub_categories')->where('category_id', '=', $cat_id)->get();
        }
    }
    public function getSubSubCategories($subcat_id)
    {
        if ($subcat_id == null) {
            return response()->json(['alert' => 'Invalid User ID'], 404);
        } else {
            return DB::table('sub_sub_category')->where('sub_category_id', '=', $subcat_id)->get();
        }
    }
    public function addCategory(Request $request)
    {
        $validate = $request->validate([
            'catIcon' => 'required|mimes:svg|max:2000'
        ]);
        if ($validate) {
            $reqDecode = json_decode($request->data, true);
            $file_name = 'cat' . '_' . $reqDecode['catEnglish'] . '.' . $request->catIcon->getClientOriginalExtension();
            $file_path = $request->file('catIcon')->storeAs('cats-icons', $file_name, 'public');
            DB::table('categories')->insert([
                "title_ar" => $reqDecode['catArabic'],
                "title_en" => $reqDecode['catEnglish'],
                "icon" => $file_name
            ]);
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['alert' => 'Invalid MIME Type'], 404);
        }
    }
    public function addSubCategory(Request $request)
    {
        DB::table('sub_categories')->insert([
            "title_ar" => $request->subCatArabic,
            "title_en" => $request->subCatEnglish,
            "category_id" => $request->catID
        ]);
        return response()->json(['success' => 'Added successfully.']);
    }
    public function addSubSubCategory(Request $request)
    {
        DB::table('sub_sub_category')->insert([
            "title_ar" => $request->subSubCatArabic,
            "title_en" => $request->subSubCatEnglish,
            "sub_category_id" => $request->subCatID
        ]);
        return response()->json(['success' => 'Added successfully.']);
    }
}
