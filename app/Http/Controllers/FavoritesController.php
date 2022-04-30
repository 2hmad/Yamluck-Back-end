<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function add(Request $request)
    {
        return Favorites::updateOrCreate([
            'user' => $request->user,
            'product' => $request->product_id
        ]);
    }
    public function delete(Request $request)
    {
        return Favorites::where('user', $request->user)->where('product', $request->product_id)->delete();
    }
}
