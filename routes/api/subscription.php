<?php

use App\Http\Controllers\Api\Subscription\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('subscriptions', SubscriptionController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
