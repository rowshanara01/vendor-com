<?php

use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DistrictController;
use App\Http\Controllers\Api\Admin\DivisionController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\SliderController;
use App\Http\Controllers\api\Seller\sellerListController;
use App\Http\Controllers\Api\shopController;
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

Route::prefix('v1')->group(function () {
    Route::get('sliders', [SliderController::class, 'index']);
    Route::get('brands', [BrandController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('nav-categories', [CategoryController::class, 'navCategory']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('single-products/{slug}', [ProductController::class, 'productBySlug']);
    Route::get('divisions', [DivisionController::class, 'index']);
    Route::get('district/{division}', [DivisionController::class, 'divisionBydistrictId']);

    Route::get('sellers', [sellerListController::class, 'index']);
    Route::get('shop-sideBar', [shopController::class, 'sideBar']);
    Route::get('products-shop', [shopController::class, 'index']);
    Route::get('sellers/products/{slug}', [sellerListController::class, 'sellerProducts']);
});
