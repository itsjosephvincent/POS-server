<?php

use App\Http\Controllers\Api\Store\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
