<?php

namespace Domain\Subscription\Actions;

use Domain\Subscription\Models\SubscriptionDetail;

class GetSubscriptionDetailByPeriodAction
{
    public function __invoke(
        int $subscriptionId,
        int $period,
    ): SubscriptionDetail
    {
        return SubscriptionDetail::where('subscription_id', '=', $subscriptionId)
            ->orderBy('id')
            ->skip($period - 1)
            ->firstOrFail();
    }

}
