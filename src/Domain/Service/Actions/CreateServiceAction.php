<?php

namespace Domain\Service\Actions;

use Domain\Service\DataTransferObjects\ServiceCreateData;
use Domain\Service\Helpers\ServiceStatus;
use Domain\Service\Models\Service;

class CreateServiceAction
{
    public function __invoke(ServiceCreateData $serviceData): Service
    {
        return Service::create([
            'name' => $serviceData->name,
            'customer_id' => $serviceData->customerId,
            'state' => ServiceStatus::Pending,
        ]);
    }
}
