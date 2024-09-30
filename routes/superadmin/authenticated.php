<?php

use App\Http\Controllers\Api\Superadmin\AdminController;
use App\Http\Controllers\Api\Superadmin\AuthController;
use App\Http\Controllers\Api\Superadmin\CashierController;
use App\Http\Controllers\Api\Superadmin\StoreController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'admins' => AdminController::class,
        'cashiers' => CashierController::class,
        'stores' => StoreController::class,
    ]);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
