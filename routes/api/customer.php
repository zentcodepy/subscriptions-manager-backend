<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('customers', \App\Http\Controllers\Api\Customer\CustomerController::class)->only(['store', 'update', 'delete']);
});
