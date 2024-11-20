<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CashierController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'stores' => StoreController::class,
        'orders' => OrderController::class,
    ]);

    Route::prefix('products')->group(function () {
        Route::post('/import/file', [ProductController::class, 'import']);
    });
    Route::prefix('reports')->group(function () {
        Route::get('/summary', [ReportController::class, 'summary']);
        Route::get('/popular_items', [ReportController::class, 'popular_items']);
        Route::get('/category_earnings', [ReportController::class, 'category_earnings']);
        Route::get('/store_earnings', [ReportController::class, 'store_earnings']);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
