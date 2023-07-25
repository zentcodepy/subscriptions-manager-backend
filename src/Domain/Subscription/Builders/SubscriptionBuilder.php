<?php

namespace Domain\Subscription\Builders;

use Domain\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Subscription>
 */
class SubscriptionBuilder extends Builder
{
    public function whereStatus(?string $search): self
    {
        return $this->when($search,
            fn(SubscriptionBuilder $q, $search) =>
                $q->where('status', '=', $search));
    }

}
