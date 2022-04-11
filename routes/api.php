<?php

// Admin Controllers
use App\Http\Controllers\Admin\ActivitiesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdsAdminController;
use App\Http\Controllers\Admin\CategoriesAdminController;
use App\Http\Controllers\Admin\HomeSettingsController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\OffersAdminController;
use App\Http\Controllers\Admin\UsersController;
// End Admin Controllers

// Api Controllers
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
use App\Http\Controllers\Api\InterestsController;
use App\Http\Controllers\CheckPhoneController;
use App\Models\Users;
use Illuminate\Support\Facades\Route;
// End Api Controllers 

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

Route::post('login', [LoginController::class, 'login']);

Route::post('auth/facebook', [SocialAuthController::class, 'facebook']);
Route::post('auth/google', [SocialAuthController::class, 'google']);

Route::post('reset-password', [ResetPasswordController::class, 'reset']);
Route::post('update-password/{code}', [ResetPasswordController::class, 'update']);

Route::post('offers/{limit}', [OffersController::class, 'randomOffers']);
Route::get('get-offers/{category_id}', [OffersController::class, 'getOffers']);
Route::get('get-sub-offers/{sub_category_id}', [OffersController::class, 'getSubOffers']);
Route::get('get-sub-sub-offers/{sub_sub_category_id}', [OffersController::class, 'getSubSubOffers']);

Route::get('product/{id}', [ProductController::class, 'getProduct']);
Route::get('similar-product/{id}', [ProductController::class, 'getSimilarProduct']);

Route::get('get-categories', [CategoriesController::class, 'getCategories']);
Route::get('categories-limited/{count}', [CategoriesController::class, 'getCategoriesLimit']);
Route::get('get-subcategory/{cat_id}', [CategoriesController::class, 'getSubCategories']);
Route::get('get-subsubcategory/{subcat_id}', [CategoriesController::class, 'getSubSubCategories']);

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
Route::post('count-notifications', [NotificationController::class, 'count']);
Route::post('get-notifications', [NotificationController::class, 'fetch']);

Route::post('update-phone', [CheckPhoneController::class, 'update']);
Route::get('get-ad', [AdsController::class, 'get']);
Route::get('carousels', [HomeSettingsController::class, 'carousels']);

Route::post('getInterest', [InterestsController::class, 'get']);
Route::post('updateInterest', [InterestsController::class, 'update']);

// Admin Panel Routes
Route::group(['prefix' => "admin"], function () {
    Route::post('users', [UsersController::class, 'index'])->middleware('verifyAdminToken');
    Route::post('block-user', [UsersController::class, 'switchBlock'])->middleware('verifyAdminToken');
    Route::post('deleteUser', [UsersController::class, 'deleteUser'])->middleware('verifyAdminToken');
    Route::post('activities', [ActivitiesController::class, 'index'])->middleware('verifyAdminToken');
    Route::post('categories', [CategoriesAdminController::class, 'index'])->middleware('verifyAdminToken');
    Route::post('categories/delete', [CategoriesAdminController::class, 'delete'])->middleware('verifyAdminToken');
    Route::post('subCat', [CategoriesAdminController::class, 'getSubCat'])->middleware('verifyAdminToken');
    Route::post('subCat/delete', [CategoriesAdminController::class, 'deleteSubCat'])->middleware('verifyAdminToken');
    Route::post('subSubCat', [CategoriesAdminController::class, 'getSubSubCat'])->middleware('verifyAdminToken');
    Route::post('subSubCat/delete', [CategoriesAdminController::class, 'deleteSubSubCat'])->middleware('verifyAdminToken');

    Route::post('add-category', [CategoriesController::class, 'addCategory'])->middleware('verifyAdminToken');
    Route::post('add-subcategory', [CategoriesController::class, 'addSubCategory'])->middleware('verifyAdminToken');
    Route::post('add-subsubcategory', [CategoriesController::class, 'addSubSubCategory'])->middleware('verifyAdminToken');

    Route::group(['prefix' => 'activities'], function () {
        Route::post('getTotalBalances', [ActivitiesController::class, 'getTotalBalances'])->middleware('verifyAdminToken');
        Route::post('getSpentBalances', [ActivitiesController::class, 'getSpentBalances'])->middleware('verifyAdminToken');
        Route::post('getTodayTransactions', [ActivitiesController::class, 'getTodayTransactions'])->middleware('verifyAdminToken');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('getTotalUsers', [UsersController::class, 'getTotalUsers'])->middleware('verifyAdminToken');
        Route::post('getActiveUsers', [UsersController::class, 'getActiveUsers'])->middleware('verifyAdminToken');
        Route::post('getPendingUsers', [UsersController::class, 'getPendingUsers'])->middleware('verifyAdminToken');
    });

    Route::post('offers', [OffersAdminController::class, 'index'])->middleware('verifyAdminToken');
    Route::post('getSubs', [OffersAdminController::class, 'getSubs'])->middleware('verifyAdminToken');

    Route::post('add-offer', [OffersController::class, 'addOffer'])->middleware('verifyAdminToken');
    Route::post('offer/closeOffer', [OffersAdminController::class, 'closeOffer'])->middleware('verifyAdminToken');
    Route::post('offer/updateOffer', [OffersAdminController::class, 'updateOffer'])->middleware('verifyAdminToken');
    Route::post('offer/finishOffer', [OffersAdminController::class, 'finishOffer'])->middleware('verifyAdminToken');
    Route::post('offer/getWinner', [OffersAdminController::class, 'getWinner'])->middleware('verifyAdminToken');

    Route::post('invoices', [InvoicesController::class, 'index'])->middleware('verifyAdminToken');

    Route::post('getAd', [AdsAdminController::class, 'getAd'])->middleware('verifyAdminToken');
    Route::post('add-ad', [AdsController::class, 'addAd'])->middleware('verifyAdminToken');

    Route::post('send-notify', [NotificationsController::class, 'sendNotify'])->middleware('verifyAdminToken');
    Route::post('bulk-message', [NotificationsController::class, 'bulkMessage'])->middleware('verifyAdminToken');

    Route::post('admin/login', [AdminController::class, 'login']);
    Route::post('admin/add', [AdminController::class, 'addAdmin'])->middleware('verifyAdminToken');
    Route::post('admin/delete', [AdminController::class, 'deleteAdmin'])->middleware('verifyAdminToken');
    Route::post('admin/admins', [AdminController::class, 'admins'])->middleware('verifyAdminToken');

    Route::post('change-password', [AdminController::class, 'change_password'])->middleware('verifyAdminToken');

    Route::post('addCarousel', [HomeSettingsController::class, 'addCarousel'])->middleware('verifyAdminToken');
    Route::post('deleteCarousel', [HomeSettingsController::class, 'deleteCarousel'])->middleware('verifyAdminToken');

    Route::get('mostCountries', function () {
        return App\Models\CountryRepeat::join('countries', 'countries_reports.country', '=', 'countries.id')->groupBy(['countries_reports.country', 'countries.name_en', 'countries_reports.repeat'])->orderByRaw('COUNT(*) DESC')->get(['countries.name_en', 'countries_reports.repeat']);
    });
    Route::get('mostAges', function () {
        return App\Models\AgesRepeat::groupBy(['ages_reports.year', 'ages_reports.repeat'])->orderByRaw('COUNT(*) DESC')->get(['ages_reports.year', 'ages_reports.repeat']);
    });
});
