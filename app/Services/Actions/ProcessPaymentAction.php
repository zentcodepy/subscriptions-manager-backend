<?php

namespace App\Services\Actions;

use App\Services\SubscriptionPayment\SubscriptionPaymentFactory;
use Domain\Subscription\Actions\UpdateSubscriptionDetailStatusAction;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Exception;

class ProcessPaymentAction
{
    public function __construct(private UpdateSubscriptionDetailStatusAction $updateSubscriptionDetailStatusAction)
    {
    }

    /**
     * @param array<string, mixed> $data
     * @throws Exception
     */
    public function __invoke(PaymentServiceTypes $paymentService, array $data): void
    {
        $processedSubscriptionPaymentData = SubscriptionPaymentFactory::create($paymentService)->processPaymentAttempt($data);

        ($this->updateSubscriptionDetailStatusAction)(
            $processedSubscriptionPaymentData->getSubscriptionDetail(),
            $processedSubscriptionPaymentData->getSubscriptionDetailUpdateStatusData(),
        );
    }
}
