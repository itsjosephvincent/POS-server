<?php

use App\Http\Controllers\Api\Store\AuthController;
use App\Http\Controllers\Api\Store\CashierController;
use App\Http\Controllers\Api\Store\TableController;
use App\Http\Controllers\Api\Store\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'tables' => TableController::class,
    ]);

    Route::prefix('reports')->group(function () {
        Route::get('/summary', [ReportController::class, 'summary']);
        Route::get('/popular_items', [ReportController::class, 'popular_items']);
        Route::get('/category_earnings', [ReportController::class, 'category_earnings']);
        Route::get('/store_earnings', [ReportController::class, 'store_earnings']);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
