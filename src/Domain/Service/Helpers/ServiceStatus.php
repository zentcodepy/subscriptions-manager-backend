<?php

namespace Domain\Service\Helpers;

enum ServiceStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Inactive = 'inactive';
}
