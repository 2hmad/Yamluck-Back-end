<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivitiesController extends Controller
{
    public function index()
    {
        return DB::table('activities')->orderBy('id', 'DESC')->get();
    }
    public function getTotalBalances()
    {
        return DB::table('yamluck')->sum('amount');
    }
    public function getSpentBalances()
    {
        return DB::table('activities')->where('type', 'withdraw-balance')->sum('amount');
    }
    public function getTodayTransactions()
    {
        return DB::table('activities')->where('date', date('Y-m-d'))->sum('amount');
    }
}
