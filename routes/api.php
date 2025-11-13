<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
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

Route::get('products', [ProductController::class,'index']);
Route::get('products/{id}', [ProductController::class,'show'])->where('id', '[0-9]+');

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{id}', [CategoryController::class, 'show']); 

Route::get('/categories/{id}/products', [CategoryProductController::class, 'index']); 
