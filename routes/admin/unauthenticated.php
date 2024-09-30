<?php

use App\Http\Controllers\Api\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
});
