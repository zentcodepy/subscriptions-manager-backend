<?php

namespace Domain\Subscription\Actions;

use Domain\Subscription\DataTransferObjects\SubscriptionDetailUpdateData;
use Domain\Subscription\Models\SubscriptionDetail;

class UpdateSubscriptionDetailAction
{
    public function __invoke(SubscriptionDetail $subscriptionDetail, SubscriptionDetailUpdateData $subscriptionDetailData): SubscriptionDetail
    {
        $subscriptionDetail->update([
            'status' => $subscriptionDetailData->status,
            'payment_info' => $subscriptionDetailData->paymentInfo,
        ]);

        return $subscriptionDetail;
    }
}
