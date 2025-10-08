<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestContoller;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    // Роут без авторизации
    Route::post('login', [AuthController::class,'login']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('register', [RegistrationController::class, 'register']);

    // Роуты, требующие JWT
    Route::middleware('jwt.auth')->group(function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

});

Route::get('test', [ProductController::class,'index']);