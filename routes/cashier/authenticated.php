<?php

use App\Http\Controllers\Api\Cashier\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
