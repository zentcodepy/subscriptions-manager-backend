<?php

namespace Domain\Subscription\Actions;


use Domain\Subscription\DataTransferObjects\UpdateSubscriptionDetailStatusData;
use Domain\Subscription\Models\SubscriptionDetail;

class UpdateSubscriptionDetailStatusAction
{
    public function __invoke(
        SubscriptionDetail $subscriptionDetail,
        UpdateSubscriptionDetailStatusData $updateSubscriptionDetailStatusData
    ): void
    {
        //todo: add payed_at if necessary
        $subscriptionDetail->update([
            'status' => $updateSubscriptionDetailStatusData->status,
            'payment_info' => $updateSubscriptionDetailStatusData->paymentInfo,
        ]);
    }

}
