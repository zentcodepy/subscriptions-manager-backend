<?php

namespace Domain\Subscription\Builders;

use Domain\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Subscription>
 */
class SubscriptionBuilder extends Builder
{
    public function whereStatus(?string $status): self
    {
        return $this->when($status,
            fn(SubscriptionBuilder $q) =>
                $q->where('status', '=', $status));
    }

    public function whereServiceId(?int $serviceId): self
    {
        return $this->when($serviceId,
            fn(SubscriptionBuilder $q) =>
            $q->where('service_id', '=', $serviceId));
    }

}
