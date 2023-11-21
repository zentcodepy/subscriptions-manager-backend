<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Api\Auth\AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Api\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
