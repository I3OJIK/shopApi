<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')
    ->group(function () {

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
