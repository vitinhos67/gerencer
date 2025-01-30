<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'user'], function () {
    Route::post('/', [UserController::class, 'create']);
    Route::get('/', [UserController::class, 'get']);
});



Route::group(['prefix' => 'products'], function () {
    Route::post('/', [ProductsController::class, 'create']);
    Route::get('/', [ProductsController::class, 'get']);
});

Route::group(['prefix' => 'supplier'], function () {
    Route::post('/', [SuppliersController::class, 'create']);
});