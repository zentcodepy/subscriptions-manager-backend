<?php

namespace App\Services\SubscriptionPayment\Interfaces;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;

interface SubscriptionPaymentStrategy
{
    /**
     * @param array<string, mixed> $data
     */
    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData;
}
