<?php

use App\Http\Controllers\Api\Store\AuthController;
use App\Http\Controllers\Api\Store\CashierController;
use App\Http\Controllers\Api\Store\ReportController;
use App\Http\Controllers\Api\Store\OrderController;
use App\Http\Controllers\Api\Store\TableController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'tables' => TableController::class,
        'orders' => OrderController::class,
    ]);

    Route::prefix('reports')->group(function () {
        Route::get('/summary', [ReportController::class, 'summary']);
        Route::get('/popular_items', [ReportController::class, 'popular_items']);
        Route::get('/category_earnings', [ReportController::class, 'category_earnings']);
        Route::get('/store_earnings', [ReportController::class, 'store_earnings']);
        Route::get('/item_sales', [ReportController::class, 'item_sales']);
        Route::get('/cashier_sales', [ReportController::class, 'cashier_sales']);
        Route::get('/category_sales', [ReportController::class, 'category_sales']);
        Route::get('/item_sales_daily', [ReportController::class, 'item_sales_daily']);
        Route::get('/cashier_sales_daily', [ReportController::class, 'cashier_sales_daily']);
        Route::get('/category_sales_daily', [ReportController::class, 'category_sales_daily']);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
