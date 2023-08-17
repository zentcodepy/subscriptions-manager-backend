<?php

namespace App\Services\Actions;

use App\Services\SubscriptionPayment\SubscriptionPaymentContext;
use Domain\Subscription\Actions\UpdateSubscriptionDetailStatusAction;

class ProcessPaymentAction
{
    public function __construct(private UpdateSubscriptionDetailStatusAction $updateSubscriptionDetailStatusAction)
    {
    }

    public function __invoke($paymentService, array $data)
    {
        $processedSubscriptionPaymentData = SubscriptionPaymentContext::initByPaymentService($paymentService)->processPaymentAttempt($data);

        ($this->updateSubscriptionDetailStatusAction)(
            $processedSubscriptionPaymentData->getSubscriptionDetail(),
            $processedSubscriptionPaymentData->getUpdateSubscriptionDetailStatusData(),
        );
    }
}
