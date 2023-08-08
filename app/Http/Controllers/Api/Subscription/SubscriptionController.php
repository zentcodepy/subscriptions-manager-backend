<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Domain\Service\DataTransferObjects\ServiceIndexFilterData;
use Domain\Service\Models\Service;
use Domain\Service\Resources\ServiceIndexResource;
use Domain\Subscription\Actions\CreateSubscriptionAction;
use Domain\Subscription\DataTransferObjects\SubscriptionCreateData;
use Domain\Subscription\DataTransferObjects\SubscriptionIndexFilterData;
use Domain\Subscription\Models\Subscription;
use Domain\Subscription\Resources\SubscriptionIndexResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use function response;

class SubscriptionController extends Controller
{
    public function index(SubscriptionIndexFilterData $subscriptionIndexFilterData): AnonymousResourceCollection
    {
        $subscriptions = Subscription::query()
            ->whereStatus($subscriptionIndexFilterData->status)
            ->whereServiceId($subscriptionIndexFilterData->serviceId)
            ->orderByDesc('id')
            ->paginate(20);

        return SubscriptionIndexResource::collection($subscriptions);
    }

    public function store(
        SubscriptionCreateData $subscriptionCreateData,
        CreateSubscriptionAction $createSubscriptionAction
    ): JsonResponse
    {
        $createSubscriptionAction($subscriptionCreateData);

        return response()->json([], Response::HTTP_CREATED);
    }

}
