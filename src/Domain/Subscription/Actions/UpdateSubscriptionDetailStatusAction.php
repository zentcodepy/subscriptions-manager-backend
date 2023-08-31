<?php

namespace Domain\Subscription\Actions;


use Domain\Subscription\DataTransferObjects\UpdateSubscriptionDetailStatusData;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;

class UpdateSubscriptionDetailStatusAction
{
    public function __invoke(
        SubscriptionDetail $subscriptionDetail,
        UpdateSubscriptionDetailStatusData $updateSubscriptionDetailStatusData
    ): void
    {
        $updateData = [
            'status' => $updateSubscriptionDetailStatusData->status,
            'payment_info' => $updateSubscriptionDetailStatusData->paymentInfo,
        ];

        if($updateSubscriptionDetailStatusData->status === SubscriptionDetailStatus::Payed
        && $subscriptionDetail->payed_at === null) {
            $updateData['payed_at'] = now();
        }

        $subscriptionDetail->update($updateData);
    }

}
