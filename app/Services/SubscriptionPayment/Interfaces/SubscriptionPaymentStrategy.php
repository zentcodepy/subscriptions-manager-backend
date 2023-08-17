<?php

namespace App\Services\SubscriptionPayment\Interfaces;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;

interface SubscriptionPaymentStrategy
{
    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData;
}
