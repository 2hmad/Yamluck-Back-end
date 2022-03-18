<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\AdsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OffersController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PaypalController;
use App\Http\Controllers\Api\PayWithYamluck;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\SubscribeController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WinnerController;
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

    Route::post('login', [LoginController::class, 'login']);

    Route::post('auth/facebook', [SocialAuthController::class, 'facebook']);
    Route::post('auth/google', [SocialAuthController::class, 'google']);

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
    Route::post('add-category', [CategoriesController::class, 'addCategory']);
    Route::post('add-subcategory', [CategoriesController::class, 'addSubCategory']);
    Route::post('add-subsubcategory', [CategoriesController::class, 'addSubSubCategory']);

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

    Route::post('offer/subscribe', [SubscribeController::class, 'subscribe'])->middleware('verifyApiKey');
    Route::post('offer/subscribers', [SubscribeController::class, 'getSubscribers'])->middleware('verifyApiKey');
    Route::post('offer/winner', [WinnerController::class, 'winner'])->middleware('verifyApiKey');
    Route::post('offer/winner/confirm', [WinnerController::class, 'confirm'])->middleware('verifyApiKey');
    Route::post('offer/pay-with-yamluck', [PayWithYamluck::class, 'pay'])->middleware('verifyApiKey');

    Route::post('payment/{type}', [PaymentController::class, 'pay'])->middleware('verifyApiKey');

    Route::get('paypal/index', [PayPalController::class, 'view']);
    Route::get('paypal/{product_id}/{auth}', [PayPalController::class, 'index'])->name('paypalIndex');
    Route::get('paypal/return/{product_id}/{auth}', [PaypalController::class, 'paypalReturn']);
    Route::get('paypal/cancel', [PaypalController::class, 'paypalCancel'])->name('paypalCancel');

    Route::post('notification', [NotificationController::class, 'switch']);
});
