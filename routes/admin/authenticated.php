<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CashierController;
use App\Http\Controllers\Api\Admin\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'cashiers' => CashierController::class,
        'stores' => StoreController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
