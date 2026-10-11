<?php

use App\Http\Controllers\Api\Admin\adminController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\SliderController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DivisionController;
use App\Http\Controllers\Api\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;

route::controller(adminController::class)->group(function(){
    Route::post('/login', 'login');
});

Route::middleware('auth:admin-api')->group(function () {
    Route::controller(adminController::class)->group(function(){
        Route::post('/logout','logout');
        Route::get('/me','user');
    });

    Route::apiResources([
        'sliders'       => SliderController::class,
        'brands'        => BrandController::class,
        'categories'    => CategoryController::class,
        'subCategories' => SubCategoryController::class,
        'products'      => ProductController::class,
        'divisions'     => DivisionController::class,
    ]);
});
