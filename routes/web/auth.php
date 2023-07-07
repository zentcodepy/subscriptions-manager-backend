<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
