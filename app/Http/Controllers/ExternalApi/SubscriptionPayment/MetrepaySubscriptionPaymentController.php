<?php

namespace App\Http\Controllers\ExternalApi\SubscriptionPayment;

use App\Services\Actions\ProcessPaymentAction;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MetrepaySubscriptionPaymentController extends Controller
{
    public function update(ProcessPaymentAction $processPaymentAction): JsonResponse
    {
        try {
            $processPaymentAction(PaymentServiceTypes::Metrepay, request()->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error inesperado.'], 500);
        }

        return response()->json();
    }
}
