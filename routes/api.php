<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\DB;
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

Route::group(['middleware' => ['web']], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::get('register/facebook', [RegisterController::class, 'facebookRedirect']);
    Route::get('register/facebook/callback', [RegisterController::class, 'facebookCallback']);

    Route::get('register/twitter', [RegisterController::class, 'twitterRedirect']);
    Route::get('register/twitter/callback', [RegisterController::class, 'twitterCallback']);

    Route::post('login', [LoginController::class, 'login']);
    Route::get('login/{service}', [LoginController::class, 'social']);

    Route::get('offers/{limit}', [OffersController::class, 'randomOffers']);
    Route::get('get-offers/{category_id}', [OffersController::class, 'getOffers']);
    Route::get('get-sub-offers/{sub_category_id}', [OffersController::class, 'getSubOffers']);
    Route::get('get-sub-sub-offers/{sub_sub_category_id}', [OffersController::class, 'getSubSubOffers']);

    Route::get('product/{id}', [ProductController::class, 'getProduct']);
    Route::get('similar-product/{id}', [ProductController::class, 'getSimilarProduct']);

    Route::get('get-categories', [CategoriesController::class, 'getCategories']);
    Route::get('categories-limited/{count}', [CategoriesController::class, 'getCategoriesLimit']);
    Route::get('get-subcategory/{cat_id}', [CategoriesController::class, 'getSubCategories']);
    Route::get('get-subsubcategory/{subcat_id}', [CategoriesController::class, 'getSubSubCategories']);

    Route::get('get-ad', [AdsController::class, 'get']);

    Route::get('countries', [CountriesController::class, 'getCountries']);
    Route::get('cities/{country_id}', [CountriesController::class, 'getCities']);
});
