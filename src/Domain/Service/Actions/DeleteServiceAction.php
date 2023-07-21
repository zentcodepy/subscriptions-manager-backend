<?php

namespace Domain\Service\Actions;

use Domain\Service\Models\Service;

class DeleteServiceAction
{
    public function __invoke(Service $service): ?bool
    {
        return $service->delete();
    }
}
