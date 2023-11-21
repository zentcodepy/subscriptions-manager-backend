<?php

namespace Domain\Subscription\Actions;

use Carbon\Carbon;

class CalculateSubscriptionDetailSchedulePaymentDateAction
{
    public function __invoke(Carbon $subscriptionFrom, int $period): Carbon
    {
        if($period <= 1) return $subscriptionFrom;

        return $subscriptionFrom->copy()->addMonths($period - 1);
    }
}
