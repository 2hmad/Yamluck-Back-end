<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request, $keyword)
    {
        return Offers::where('title_ar', 'LIKE', '%' . $keyword . '%')
            ->orWhere('title_en', 'LIKE', '%' . $keyword . '%')
            ->orWhere('details_ar', 'LIKE', '%' . $keyword . '%')
            ->orWhere('details_en', 'LIKE', '%' . $keyword . '%')
            ->orWhere('details_en', 'LIKE', '%' . $keyword . '%')
            ->orWhere('gift_en', 'LIKE', '%' . $keyword . '%')
            ->orWhere('gift_ar', 'LIKE', '%' . $keyword . '%')
            ->with(['country', 'city', 'user', 'similar'])->get();
    }
}
