<?php

use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\CreateInvoiceController;
use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
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
});
Route::get('/invoice/{id}', [CreateInvoiceController::class, 'index']);
