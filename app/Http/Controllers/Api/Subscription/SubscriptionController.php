<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Domain\Subscription\Actions\CreateSubscriptionAction;
use Domain\Subscription\DataTransferObjects\SubscriptionCreateData;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

class SubscriptionController extends Controller
{
    public function store(
        SubscriptionCreateData $subscriptionCreateData,
        CreateSubscriptionAction $createSubscriptionAction
    ): JsonResponse
    {
        $createSubscriptionAction($subscriptionCreateData);

        return response()->json([], Response::HTTP_CREATED);
    }

}
