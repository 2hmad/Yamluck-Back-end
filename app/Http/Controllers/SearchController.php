<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        return DB::table('offers')
            ->where('title_ar', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('title_en', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('details_ar', 'LIKE', '%' . $request->keyword . '%')
            ->orWhere('details_en', 'LIKE', '%' . $request->keyword . '%')
            ->get([
                'id',
                'title_ar',
                'title_en',
                'details_ar',
                'details_en',
                'price',
                'publish_date',
                'curr_subs',
                'pic_one'
            ]);
    }
}
