<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MarketingBannerController;
use App\Http\Controllers\Api\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyByLink']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('api.token')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/cart',[CartController::class,'index']);

    Route::post('/cart/add',[CartController::class,'add']);

    Route::patch('/cart/{id}',[CartController::class,'update']);

    Route::delete('/cart/{id}',[CartController::class,'remove']);

    Route::delete('/cart',[CartController::class,'clear']);

    Route::get('/checkout', [OrderController::class, 'checkout']);
    Route::post(
        '/place-order',
        [OrderController::class, 'placeOrder']
    );

    Route::get('/my-orders', [OrderController::class, 'myOrders']);

    Route::get('/my-orders/{id}', [OrderController::class, 'orderDetails']);
    Route::get('/orders/{id}/status', [OrderController::class, 'orderStatus']);

    Route::get('/transactions', [OrderController::class, 'transactions']);


    Route::post('/orders/{id}/review', [OrderController::class, 'submitReview']);

    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);

    Route::post('/orders/{id}/evidence', [OrderController::class, 'uploadCustomerEvidence']);

    Route::get('/profile', [AuthController::class, 'index']);

    Route::post('/profile/update', [AuthController::class, 'update']);
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    Route::get('/loyalty/rewards', [OrderController::class, 'customerLoyaltyRewards']);

});

Route::post(
    '/driverwebhook',
    [OrderController::class, 'driverwebhook']
);


Route::get('/core/home', [HomeController::class, 'home']);

Route::get('/category-products/{id}', [HomeController::class, 'categoryProducts']);

Route::get('/product-details/{id}', [HomeController::class, 'productDetails']);

Route::match(['GET', 'POST'], '/restaurants', [HomeController::class, 'restaurants']);


Route::get('/restaurant/{slug}', [HomeController::class, 'restaurantProducts']);

Route::get('/restaurant/{slug}/category/{categorySlug}', [HomeController::class, 'restaurantCategoryProducts']);



Route::get('/marketing-banners', [MarketingBannerController::class, 'index']);

Route::get('/marketing-banners/{id}', [MarketingBannerController::class, 'show']);

Route::post('/marketing-banners/contact', [MarketingBannerController::class, 'contact']);