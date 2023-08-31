<?php

namespace App\Services\SubscriptionPayment\DataTransferObjects;

use Domain\Subscription\DataTransferObjects\UpdateSubscriptionDetailStatusData;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;

class ProcessedSubscriptionPaymentData
{
    public function __construct(
        public readonly SubscriptionDetail $subscriptionDetail,
        public readonly SubscriptionDetailStatus $status,
        public readonly ?string $paymentInfo,
    )
    {}

    public function getSubscriptionDetail(): SubscriptionDetail
    {
        return $this->subscriptionDetail;
    }

    public function getUpdateSubscriptionDetailStatusData(): UpdateSubscriptionDetailStatusData
    {
        return new UpdateSubscriptionDetailStatusData($this->status, $this->paymentInfo);
    }

}