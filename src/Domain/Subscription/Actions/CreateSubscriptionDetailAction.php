<?php

namespace Domain\Subscription\Actions;

use Domain\Subscription\DataTransferObjects\SubscriptionDetailCreateData;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;

class CreateSubscriptionDetailAction
{
    public function __construct()
    {}

    public function __invoke(SubscriptionDetailCreateData $subscriptionDetailData): SubscriptionDetail
    {
        return SubscriptionDetail::create([
            'subscription_id' => $subscriptionDetailData->subscriptionId,
            'status' => SubscriptionDetailStatus::Pending,
            'amount' => $subscriptionDetailData->amount,
            'schedule_payment_date' => $subscriptionDetailData->schedulePaymentDate,
        ]);
    }
}
