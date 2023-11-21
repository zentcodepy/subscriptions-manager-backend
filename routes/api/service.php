<?php

use App\Http\Controllers\Api\Service\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('service/search', [ServiceController::class, 'search'])
        ->name('services.search');

    Route::resource('services', ServiceController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
