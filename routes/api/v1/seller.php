<?php

use App\Http\Controllers\Api\Seller\sellerController;
use Illuminate\Support\Facades\Route;

route::controller(sellerController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::middleware('auth:seller-api')->group(function () {
    Route::controller(sellerController::class)->group(function(){
        Route::post('/logout','logout');
        Route::get('/me','user');
    });
});