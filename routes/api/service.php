<?php

use App\Http\Controllers\Api\Service\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('customers/search', [ServiceController::class, 'search']);

    Route::resource('services', ServiceController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
