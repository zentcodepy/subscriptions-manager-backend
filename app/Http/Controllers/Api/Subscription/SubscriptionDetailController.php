<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Domain\Subscription\Actions\UpdateSubscriptionDetailAction;
use Domain\Subscription\DataTransferObjects\SubscriptionDetailUpdateData;
use Domain\Subscription\Models\SubscriptionDetail;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function response;

class SubscriptionDetailController extends Controller
{
    public function update(SubscriptionDetail $subscriptionDetail, SubscriptionDetailUpdateData $subscriptionDetailData, UpdateSubscriptionDetailAction $updateSubscriptionDetailAction): JsonResponse
    {
        $updateSubscriptionDetailAction($subscriptionDetail, $subscriptionDetailData);

        return response()->json([], Response::HTTP_OK);
    }

}
