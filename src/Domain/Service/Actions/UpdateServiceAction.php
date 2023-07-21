<?php

namespace Domain\Service\Actions;

use Domain\Service\DataTransferObjects\ServiceUpdateData;
use Domain\Service\Models\Service;

class UpdateServiceAction
{
    public function __invoke(Service $service, ServiceUpdateData $serviceData): Service
    {
        $service->update([
            'name' => $serviceData->name,
            'customer_id' => $serviceData->customerId,
            'status' => $serviceData->status,
        ]);

        return $service;
    }
}
