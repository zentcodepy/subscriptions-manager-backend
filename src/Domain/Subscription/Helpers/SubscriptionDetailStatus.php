<?php

namespace Domain\Subscription\Helpers;

enum SubscriptionDetailStatus: string
{
    case Pending = 'pending';
    case Payed = 'payed';
    case Canceled = 'canceled';
}
