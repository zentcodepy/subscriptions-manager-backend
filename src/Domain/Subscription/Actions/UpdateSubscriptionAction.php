<?php

namespace Domain\Subscription\Actions;

use Domain\Subscription\DataTransferObjects\SubscriptionUpdateData;
use Domain\Subscription\Models\Subscription;

class UpdateSubscriptionAction
{
    public function __invoke(Subscription $subscription, SubscriptionUpdateData $subscriptionData): Subscription
    {
        $subscription->update([
            'grace_period_in_days' => $subscriptionData->gracePeriodInDays,
            'status' => $subscriptionData->status,
            'payment_service_type' => $subscriptionData->paymentServiceType,
            'automatic_notification_enabled' => $subscriptionData->automaticNotificationEnabled,
            'subscription_info' => $subscriptionData->subscriptionInfo,
        ]);

        return $subscription;
    }
}
