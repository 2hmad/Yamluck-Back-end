<?php

use App\Models\Subscribe;
use App\Models\Users;
use App\Models\Verification;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Paytabs\Paytabs;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user = Subscribe::where('product_id', 1)->with('user')->get();
    return $user;
});
