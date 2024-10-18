<?php

use App\Http\Controllers\Api\Store\AuthController;
use App\Http\Controllers\Api\Store\CashierController;
use App\Http\Controllers\Api\Store\TableController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'tables' => TableController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
