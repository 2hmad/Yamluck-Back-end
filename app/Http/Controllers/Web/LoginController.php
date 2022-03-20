<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CreateInvoiceController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return Carbon::parse('11-09-2002')->age;
    }
}
