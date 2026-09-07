<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint Publik
Route::prefix("v1")->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/biometric', [AuthController::class, 'verifyBiometric'])->middleware('throttle:5,1');
    //Route::post('/biometric/register', []);

    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/biometric/register', [AuthController::class, 'registerBiometric']);

        Route::prefix('products')->group(function() {
            Route::get('/', [ProductController::class, 'getProducts']);
            Route::get('/{id}', [ProductController::class, 'detailProductById']);
        });

        Route::get('/categories', [CategoryController::class, 'getCategories']);
    });
});
