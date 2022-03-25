<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsAdminController extends Controller
{
    public function getAd()
    {
        return DB::table('ads')->first();
    }
}
