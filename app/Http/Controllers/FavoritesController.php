<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function get(Request $request)
    {
        Favorites::where('user', $request->user)->with('offer')->get();
    }
    public function add(Request $request)
    {
        $check = Favorites::where('user', $request->user)->where('product', $request->product_id)->first();
        if ($check == null) {
            return Favorites::create([
                'user' => $request->user,
                'product' => $request->product_id
            ]);
        } else {
            return response()->json(['alert' => 'Added Before'], 404);
        }
    }
    public function delete(Request $request)
    {
        return Favorites::where('user', $request->user)->where('product', $request->product_id)->delete();
    }
}
