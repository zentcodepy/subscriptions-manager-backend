<?php

namespace Domain\Service\Builders;

use Domain\Service\Models\Service;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Service>
 */
class ServiceBuilder extends Builder
{
    public function whereLikeName(?string $search): self
    {
        return $this->when($search,
            fn(ServiceBuilder $q, $search) =>
                $q->where('name', 'like', "%$search%"));
    }

}
