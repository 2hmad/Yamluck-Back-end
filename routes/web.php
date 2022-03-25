<?php

use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\CreateInvoiceController;
use App\Http\Controllers\Web\LoginController;
use App\Models\Users;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
    return md5(rand(1, 10) . microtime());
});
Route::get('/invoice/{id}', [CreateInvoiceController::class, 'index']);
