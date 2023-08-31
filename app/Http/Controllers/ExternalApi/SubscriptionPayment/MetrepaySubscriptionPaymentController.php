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
        $processPaymentAction(PaymentServiceTypes::Metrepay, request()->all());

        return response()->json();
    }
}
