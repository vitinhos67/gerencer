<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/auth/token', [AuthController::class, 'generateToken']);
Route::post('/user', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [UserController::class, 'get']);

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductsController::class, 'create']);
        Route::get('/', [ProductsController::class, 'get']);
    });

    Route::prefix('supplier')->group(function () {
        Route::post('/', [SuppliersController::class, 'create']);
    });

    Route::prefix('order')->group(function () {
        Route::post('/', [OrderController::class, 'create']);
    });
});
