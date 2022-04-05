<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function getAges()
    {
        $getBirthdates = Users::get('birthdate');
        foreach ($getBirthdates as $birthdate) {
            return Carbon::parse($birthdate->birthdate)->diff(Carbon::now())->y;
        }
    }
}
