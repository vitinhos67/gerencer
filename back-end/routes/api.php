<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Public routes
Route::post('/auth/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
Route::post('/auth/logout', [AuthController::class, 'logout'])->withoutMiddleware('auth:sanctum');
Route::post('/register', [UserController::class, 'createUser'])->withoutMiddleware('auth:sanctum');
Route::post('/supplier', [SuppliersController::class, 'create'])->withoutMiddleware('auth:sanctum');
Route::post('/webhook/notification-transaction', [TransactionsController::class, 'notification'])
    ->withoutMiddleware(['auth:sanctum']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
});

Route::middleware(['role:admin'])->group(function () {
    Route::post('/printer', [PrinterController::class, 'configPrinter']);
    Route::get('/printer', [PrinterController::class, 'get']);
});

Route::middleware(['role:moderador|admin'])->group(function () {
    Route::prefix('supplier')->group(function () {
        Route::get('/', [SuppliersController::class, 'get']);
        Route::prefix('config')->group(function () {
            Route::post('/', [SuppliersController::class, 'createConfig']);
        });
        Route::prefix('/payment-integration')->group(function () {
            Route::post('/', [SuppliersController::class, 'paymentConfig']);
        });
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductsController::class, 'create']);
        Route::get('/', [ProductsController::class, 'get']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'get']);
        Route::get('/all', [UserController::class, 'all']);
        Route::post('/', [UserController::class, 'createModerator']);
    });
});

Route::middleware(['role:user|moderador|admin'])->group(function () {
    Route::prefix('order')->group(function () {
        Route::post('/', [OrderController::class, 'create']);
        Route::get('/', [OrderController::class, 'getProducts']);
        Route::post('/payment', [PaymentController::class, 'create']);
    });
});
