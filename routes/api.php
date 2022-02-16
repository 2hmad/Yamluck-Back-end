<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('register/facebook', [RegisterController::class, 'facebookRedirect']);
Route::get('register/facebook/callback', [RegisterController::class, 'facebookCallback']);

Route::get('register/google', [RegisterController::class, 'googleRedirect']);
Route::get('register/google/callback', [RegisterController::class, 'googleCallback']);

Route::post('login', [LoginController::class, 'login']);
Route::get('login/{service}', [LoginController::class, 'social']);

Route::get('offers/{limit}', [OffersController::class, 'randomOffers']);
Route::get('get-offers/{category_id}', [OffersController::class, 'getOffers']);

Route::get('product/{id}', [ProductController::class, 'getProduct']);
Route::get('similar-product/{id}', [ProductController::class, 'getSimilarProduct']);

Route::get('get-categories', [CategoriesController::class, 'getCategories']);
Route::get('get-subcategory/{cat_id}', [CategoriesController::class, 'getSubCategories']);
Route::get('get-subsubcategory/{subcat_id}', [CategoriesController::class, 'getSubSubCategories']);

Route::get('/get-ad', [AdsController::class, 'get']);
