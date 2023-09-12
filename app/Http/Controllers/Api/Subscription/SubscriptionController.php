<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Domain\Subscription\Actions\CreateSubscriptionAction;
use Domain\Subscription\Actions\UpdateSubscriptionAction;
use Domain\Subscription\DataTransferObjects\SubscriptionCreateData;
use Domain\Subscription\DataTransferObjects\SubscriptionIndexFilterData;
use Domain\Subscription\DataTransferObjects\SubscriptionUpdateData;
use Domain\Subscription\Models\Subscription;
use Domain\Subscription\Resources\SubscriptionIndexResource;
use Domain\Subscription\Resources\SubscriptionShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use function response;

class SubscriptionController extends Controller
{
    public function index(SubscriptionIndexFilterData $subscriptionIndexFilterData): AnonymousResourceCollection
    {
        $subscriptions = Subscription::query()
            ->with([
                'service:id,name',
            ])
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

    public function show(Subscription $subscription): SubscriptionShowResource
    {
        return SubscriptionShowResource::make($subscription);
    }

    public function update(Subscription $subscription, SubscriptionUpdateData $subscriptionData, UpdateSubscriptionAction $updateSubscriptionAction): JsonResponse
    {
        $updateSubscriptionAction($subscription, $subscriptionData);

        return response()->json([], Response::HTTP_OK);
    }

}
