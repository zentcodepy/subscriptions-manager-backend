<?php

namespace App\Services\SubscriptionPayment;

use App\Services\SubscriptionPayment\Interfaces\SubscriptionPaymentStrategy;
use Domain\Subscription\Helpers\PaymentServiceTypes;

class SubscriptionPaymentFactory
{
    /**
     * @throws \Exception
     */
    public static function create(PaymentServiceTypes $paymentType): SubscriptionPaymentStrategy {
        return match ($paymentType) {
            PaymentServiceTypes::Metrepay => new MetrepaySubscriptionPaymentStrategy(),
            default => throw new \Exception('Payment Service not implemented'),
        };
    }
}
