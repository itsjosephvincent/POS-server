<?php

use App\Http\Controllers\Api\Cashier\AuthController;
use App\Http\Controllers\Api\Cashier\CategoryController;
use App\Http\Controllers\Api\Cashier\OrderController;
use App\Http\Controllers\Api\Cashier\OrderDetailController;
use App\Http\Controllers\Api\Cashier\ProductController;
use App\Http\Controllers\Api\Cashier\RunningBillController;
use App\Http\Controllers\Api\Cashier\TableController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'categories' => CategoryController::class,
        'orders' => OrderController::class,
        'order-details' => OrderDetailController::class,
        'products' => ProductController::class,
        'running-bills' => RunningBillController::class,
        'tables' => TableController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
