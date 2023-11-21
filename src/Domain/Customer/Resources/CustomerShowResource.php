<?php

namespace Domain\Customer\Resources;

use Domain\Customer\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CustomerShowResource
 *
 * @mixin Customer
 * */
class CustomerShowResource extends JsonResource
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
            'business_name' => $this->business_name,
            'document_number' => $this->document_number,
            'contact_name' => $this->contact_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'comments' => $this->comments,
        ];
    }
}
