<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CashierController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'stores' => StoreController::class,
    ]);

    Route::prefix('products')->group(function () {
        Route::post('/import/file', [ProductController::class, 'import']);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
