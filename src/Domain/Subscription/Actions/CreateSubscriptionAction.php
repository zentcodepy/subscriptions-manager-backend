<?php

namespace Domain\Subscription\Actions;

use Domain\Subscription\DataTransferObjects\SubscriptionCreateData;
use Domain\Subscription\Models\Subscription;

class CreateSubscriptionAction
{
    public function __construct(
        private CalculateDateToFromDateFromAndDurationInMonthsAction
            $calculateDateToFromDateFromAndDurationInMonthsAction
    )
    {}

    public function __invoke(SubscriptionCreateData $subscriptionData): Subscription
    {
        return Subscription::create([
            'service_id' => $subscriptionData->serviceId,
            'date_from' => $subscriptionData->dateFrom,
            'duration_in_months' => $subscriptionData->durationInMonths,
            'date_to' => ($this->calculateDateToFromDateFromAndDurationInMonthsAction)($subscriptionData->dateFrom, $subscriptionData->durationInMonths),
            'status' => $subscriptionData->status,
            'total_amount' => $subscriptionData->totalAmount,
            'grace_period_in_days' => $subscriptionData->totalAmount,
            'payment_service_type' => $subscriptionData->paymentServiceType,
            'automatic_notification_enabled' => $subscriptionData->automaticNotificationEnabled,
            'subscription_info' => $subscriptionData->subscriptionInfo,
        ]);
    }
}
