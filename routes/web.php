<?php

use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\CreateInvoiceController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

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
    return Carbon::parse('12/15/2007')->format('Y-m-d');
});
Route::get('/invoice/{id}', [CreateInvoiceController::class, 'index']);
