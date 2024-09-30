<?php

use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->group(function () {
    require 'superadmin/authenticated.php';
    require 'superadmin/unauthenticated.php';
});

Route::prefix('admin')->group(function () {
    require 'admin/authenticated.php';
    require 'admin/unauthenticated.php';
});

Route::prefix('store')->group(function () {
    require 'store/authenticated.php';
    require 'store/unauthenticated.php';
});

Route::prefix('cashier')->group(function () {
    require 'cashier/authenticated.php';
    require 'cashier/unauthenticated.php';
});
