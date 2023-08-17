<?php

namespace App\Services\SubscriptionPayment;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;
use App\Services\SubscriptionPayment\Interfaces\SubscriptionPaymentStrategy;

class SubscriptionPaymentContext
{
    public function __construct(private SubscriptionPaymentStrategy $subscriptionPaymentStrategy)
    {}

    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData
    {
        return $this->subscriptionPaymentStrategy->processPaymentAttempt($data);
    }
}
