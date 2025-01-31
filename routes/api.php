<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/auth/token', [AuthController::class, 'generateToken'])->withoutMiddleware('auth:sanctum');
Route::post('/register', [UserController::class, 'createUser'])->withoutMiddleware('auth:sanctum');
Route::post('/supplier', [SuppliersController::class, 'create'])->withoutMiddleware('auth:sanctum');

Route::middleware(['role:moderador|admin'])->group(function () {


    Route::prefix('supplier')->group(function () {
        Route::get('/', [SuppliersController::class, 'get']);
        Route::get('/journey', [SuppliersController::class, 'get']);
        

        Route::prefix('config')->group(function() {
            Route::post('/', [SuppliersController::class, 'createConfig']);
        });

    });

    
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductsController::class, 'create']);
        Route::get('/', [ProductsController::class, 'get']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'get']);
        Route::post('/', [UserController::class, 'createModerator']);
    });
});

Route::middleware(['role:user|moderador|admin'])->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::prefix('order')->group(function () {
        Route::post('/', [OrderController::class, 'create']);
    });
});
