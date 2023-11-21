<?php

namespace Domain\Subscription\Helpers;

enum SubscriptionStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Inactive = 'inactive';
}
