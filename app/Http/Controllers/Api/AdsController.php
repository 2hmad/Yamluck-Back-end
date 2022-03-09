<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function get()
    {
        return DB::table('ads')->orderBy('id', 'DESC')->first();
    }
}
