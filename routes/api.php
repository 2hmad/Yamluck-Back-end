<?php

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

Route::get('get-categories', [CategoriesController::class, 'getCategories']);
Route::get('get-subcategory/{cat_id}', [CategoriesController::class, 'getSubCategories']);
Route::get('get-subsubcategory/{subcat_id}', [CategoriesController::class, 'getSubSubCategories']);
