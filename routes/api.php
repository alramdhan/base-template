<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint Publik
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/biometric', [AuthController::class, 'loginBiometric'])->middleware('throttle:5,1');
