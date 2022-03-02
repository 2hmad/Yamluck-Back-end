<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PayWithYamluck;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WalletController;
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

Route::group(['middleware' => ['cors']], function () {
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::get('register/facebook', [RegisterController::class, 'facebookRedirect']);
    Route::get('register/facebook/callback', [RegisterController::class, 'facebookCallback']);

    Route::get('register/twitter', [RegisterController::class, 'twitterRedirect']);
    Route::get('register/twitter/callback', [RegisterController::class, 'twitterCallback']);

    Route::post('login', [LoginController::class, 'login']);

    Route::post('login/facebook', [LoginController::class, 'facebookRedirect']);
    Route::post('login/facebook/callback', [LoginController::class, 'facebookCallback']);

    Route::post('reset-password', [ResetPasswordController::class, 'reset']);
    Route::post('update-password/{code}', [ResetPasswordController::class, 'update']);

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

    Route::post('resend-code', [VerificationController::class, 'resend']);
    Route::post('verify-code', [VerificationController::class, 'verify']);

    Route::post('profile', [ProfileController::class, 'getProfile']);
    Route::post('edit-profile', [ProfileController::class, 'editProfile']);
    Route::post('change-pic', [ProfileController::class, 'changePic']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);

    Route::post('wallet/amount', [WalletController::class, 'getAmount']);
    Route::post('wallet/activities', [WalletController::class, 'getActivities']);
    Route::post('wallet/recharge', [WalletController::class, 'recharge'])->middleware('verifyApiKey');

    Route::get('search/{keyword}', [SearchController::class, 'search']);

    Route::delete('logout', function () {
        return response()->json(['alert' => 'OK'], 200);
    });

    Route::post('pay-with-yamluck', [PayWithYamluck::class, 'pay']);

    Route::post('subscribe', [SubscribeController::class, 'subscribe']);
});
