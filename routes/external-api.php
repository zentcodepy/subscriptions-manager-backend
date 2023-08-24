<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| External API Routes
|--------------------------------------------------------------------------
*/

Route::put('/subscription-payments', [\App\Http\Controllers\ExternalApi\SubscriptionPayment\MetrepaySubscriptionPaymentController::class, 'update']);
