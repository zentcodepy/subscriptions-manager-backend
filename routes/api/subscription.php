<?php

use App\Http\Controllers\Api\Subscription\SubscriptionController;
use App\Http\Controllers\Api\Subscription\SubscriptionDetailController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('subscriptions', SubscriptionController::class)
        ->only(['index', 'store', 'show', 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('subscription-details', SubscriptionDetailController::class)
        ->only(['update']);
});
