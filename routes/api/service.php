<?php

use App\Http\Controllers\Api\Service\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('services', ServiceController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
