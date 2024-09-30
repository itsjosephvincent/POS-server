<?php

use App\Http\Controllers\Api\Store\AuthController;
use App\Http\Controllers\Api\Store\CashierController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
