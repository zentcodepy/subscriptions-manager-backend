<?php

namespace Domain\Service\Builders;

use Domain\Service\Models\Service;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Service>
 */
class ServiceBuilder extends Builder
{
    public function whereLikeName(?string $name): self
    {
        return $this->when($name,
            fn(ServiceBuilder $q) =>
                $q->where('name', 'like', "%$name%"));
    }

    public function whereStatus(?string $status): self
    {
        return $this->when($status,
            fn(ServiceBuilder $q) =>
            $q->where('status', '=', $status));
    }

    public function whereCustomerId(?int $customerId): self
    {
        return $this->when($customerId,
            fn(ServiceBuilder $q) =>
            $q->where('customer_id', '=', $customerId));
    }
}
