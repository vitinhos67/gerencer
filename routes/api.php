<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'products'], function () {
    Route::post('/', [ProductsController::class, 'create']);
    Route::get('/', [ProductsController::class, 'get']);
});