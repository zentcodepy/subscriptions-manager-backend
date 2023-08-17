<?php

namespace App\Http\Controllers\ExternalApi\SubscriptionPayment;

use App\Services\SubscriptionPayment\MetrepaySubscriptionPaymentStrategy;
use App\Services\SubscriptionPayment\SubscriptionPaymentContext;
use Domain\Subscription\Actions\UpdateSubscriptionDetailStatusAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MetrepaySubscriptionPaymentController extends Controller
{
    public function update(UpdateSubscriptionDetailStatusAction $updateSubscriptionDetailStatusAction): JsonResponse
    {
        $subscriptionPaymentContext = new SubscriptionPaymentContext(new MetrepaySubscriptionPaymentStrategy());

        $processedSubscriptionPaymentData = $subscriptionPaymentContext->processPaymentAttempt(request()->all());

        $updateSubscriptionDetailStatusAction(
            $processedSubscriptionPaymentData->getSubscriptionDetail(),
            $processedSubscriptionPaymentData->getUpdateSubscriptionDetailStatusData(),
        );

        return response()->json();
    }
}
