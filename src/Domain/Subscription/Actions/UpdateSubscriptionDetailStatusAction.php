<?php

namespace Domain\Subscription\Actions;


use Domain\Subscription\DataTransferObjects\SubscriptionDetailUpdateStatusData;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;

class UpdateSubscriptionDetailStatusAction
{
    public function __invoke(
        SubscriptionDetail $subscriptionDetail,
        SubscriptionDetailUpdateStatusData $subscriptionDetailUpdateStatusData
    ): void
    {
        $updateData = [
            'status' => $subscriptionDetailUpdateStatusData->status,
            'payment_info' => $subscriptionDetailUpdateStatusData->paymentInfo,
        ];

        if($subscriptionDetailUpdateStatusData->status === SubscriptionDetailStatus::Payed
        && $subscriptionDetail->payed_at === null) {
            $updateData['payed_at'] = now();
        }

        $subscriptionDetail->update($updateData);
    }

}
