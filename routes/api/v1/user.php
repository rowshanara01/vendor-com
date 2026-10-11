<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\authController;
use App\Http\Controllers\Api\User\WishlistController;

route::controller(authController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/otp-verify', 'verifyOTP');
    Route::post('/otp-resend', 'OTPResend');
});

Route::middleware('auth:user-api')->group(function () {
    Route::controller(authController::class)->group(function(){
        Route::get('/address','address');
        Route::get('/me','user');
        Route::post('/logout','logout');
    });

    Route::apiResources([
        'wishlists'       => WishlistController::class,
    ]);
});
