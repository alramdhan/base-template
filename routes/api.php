<?php

use App\Http\Controllers\Api\AuthController;
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
    });
});
