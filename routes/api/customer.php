<?php

use App\Http\Controllers\Api\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('customers', CustomerController::class)
        ->only(['index', 'store', 'show', 'update', 'delete']);
});
