<?php

namespace App\Services\Actions;

use App\Services\SubscriptionPayment\SubscriptionPaymentFactory;
use Domain\Subscription\Actions\UpdateSubscriptionDetailStatusAction;
use Domain\Subscription\Helpers\PaymentServiceTypes;

class ProcessPaymentAction
{
    public function __construct(private UpdateSubscriptionDetailStatusAction $updateSubscriptionDetailStatusAction)
    {
    }

    public function __invoke(PaymentServiceTypes $paymentService, array $data)
    {
        $processedSubscriptionPaymentData = SubscriptionPaymentFactory::create($paymentService)->processPaymentAttempt($data);

        ($this->updateSubscriptionDetailStatusAction)(
            $processedSubscriptionPaymentData->getSubscriptionDetail(),
            $processedSubscriptionPaymentData->getUpdateSubscriptionDetailStatusData(),
        );
    }
}
