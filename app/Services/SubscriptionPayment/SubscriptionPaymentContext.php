<?php

namespace App\Services\SubscriptionPayment;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;
use App\Services\SubscriptionPayment\Interfaces\SubscriptionPaymentStrategy;
use Domain\Subscription\Helpers\PaymentServiceTypes;

class SubscriptionPaymentContext
{
    public function __construct(private SubscriptionPaymentStrategy $subscriptionPaymentStrategy)
    {}

    /**
     * @throws \Exception
     */
    public static function initByPaymentService(PaymentServiceTypes $paymentType): self {
        return match ($paymentType) {
            PaymentServiceTypes::Metrepay => new self(new MetrepaySubscriptionPaymentStrategy()),
            default => throw new \Exception('Payment Service not implemented'),
        };
    }

    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData
    {
        return $this->subscriptionPaymentStrategy->processPaymentAttempt($data);
    }
}
