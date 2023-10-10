<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Domain\Subscription\Actions\UpdateSubscriptionDetailStatusAction;
use Domain\Subscription\DataTransferObjects\SubscriptionDetailUpdateStatusData;
use Domain\Subscription\Models\SubscriptionDetail;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

class SubscriptionDetailController extends Controller
{
    public function update(SubscriptionDetail $subscriptionDetail, SubscriptionDetailUpdateStatusData $subscriptionDetailData, UpdateSubscriptionDetailStatusAction $updateSubscriptionDetailStatusAction): JsonResponse
    {
        $updateSubscriptionDetailStatusAction($subscriptionDetail, $subscriptionDetailData);

        return response()->json([], Response::HTTP_OK);
    }
}
