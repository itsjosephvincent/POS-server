<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admins', [AdminController::class, 'index']); // for superadmin
Route::post('/registration', [AdminController::class, 'store']); // Register an account
Route::get('/admin', [AdminController::class, 'show'])->middleware(['auth:sanctum']);

Route::post('/user/login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'current_user']); // get user data from passed token
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});



