<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountriesController extends Controller
{
    public function getCountries()
    {
        return DB::table('countries')->get(['id', 'name_ar', 'name_en', "code"]);
    }
    public function getCities($country_id)
    {
        return DB::table('cities')->where('country_id', '=', $country_id)->get(['id', 'name_ar', 'name_en', "code"]);
    }
}
