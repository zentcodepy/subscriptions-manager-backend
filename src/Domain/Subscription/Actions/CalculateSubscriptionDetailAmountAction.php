<?php

namespace Domain\Subscription\Actions;

class CalculateSubscriptionDetailAmountAction
{
    public function __invoke(int $subscriptionAmount, int $periods): int
    {
        return intval(round($subscriptionAmount / $periods, 0));
    }
}
