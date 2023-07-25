<?php

namespace Domain\Subscription\Helpers;

enum PaymentServiceTypes: string
{
    case Manual = 'manual';
    case Metrepay = 'metrepay';
}
