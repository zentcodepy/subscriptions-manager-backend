<?php

namespace Domain\Service\Resources;

use Domain\Service\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ServiceIndexResource
 *
 * @mixin Service
 * */
class ServiceIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'customer_name' => $this->customer->business_name,
            'status' => $this->status,
        ];
    }
}
