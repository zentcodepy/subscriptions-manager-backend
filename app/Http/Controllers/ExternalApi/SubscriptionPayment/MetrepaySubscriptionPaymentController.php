<?php

namespace App\Http\Controllers\ExternalApi\SubscriptionPayment;

use App\Services\Actions\ProcessPaymentAction;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MetrepaySubscriptionPaymentController extends Controller
{
    public function update(ProcessPaymentAction $processPaymentAction): JsonResponse
    {
        Log::info("MetrepaySubscriptionPaymentController@update data", request()->all());

        return response()->json(['message' => 'ok']);

        $processPaymentAction(PaymentServiceTypes::Metrepay, request()->all());

        return response()->json();
    }
}
