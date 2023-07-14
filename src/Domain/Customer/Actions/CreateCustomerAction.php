<?php

namespace Domain\Customer\Actions;

use Domain\Customer\DataTransferObjects\CustomerData;
use Domain\Customer\Models\Customer;

class CreateCustomerAction
{
    public function __invoke(CustomerData $customerData): Customer
    {
        return Customer::create([
            'business_name' => $customerData->businessName,
            'document_number' => $customerData->documentNumber,
            'contact_name' => $customerData->contactName,
            'phone_number' => $customerData->phoneNumber,
            'email' => $customerData->email,
            'address' => $customerData->address,
            'comments' => $customerData->comments,
        ]);
    }
}
