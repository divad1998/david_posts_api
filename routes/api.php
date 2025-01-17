<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'throttle:api'])
    ->apiResource('posts', PostController::class);

Route::prefix('auth')
    ->middleware(['api', 'throttle:api'])
    ->controller(AuthController::class)
    ->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});