<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| External API Routes
|--------------------------------------------------------------------------
*/

Route::put(
    '/subscription-payments/metrepay-strategy',
    [
        \App\Http\Controllers\ExternalApi\SubscriptionPayment\MetrepaySubscriptionPaymentController::class,
        'update'
    ]
)->name('subscription-payments.metrepay-strategy');
