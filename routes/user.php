<?php
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
});