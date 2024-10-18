<?php

use App\Http\Controllers\Api\Cashier\AuthController;
use App\Http\Controllers\Api\Cashier\CategoryController;
use App\Http\Controllers\Api\Cashier\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
