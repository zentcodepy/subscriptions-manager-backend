<?php

namespace Domain\Customer\Actions;

use Domain\Customer\DataTransferObjects\CustomerData;
use Domain\Customer\Models\Customer;

class UpdateCustomerAction
{
    public function __invoke(Customer $customer, CustomerData $customerData): Customer
    {
        $customer->update([
            'business_name' => $customerData->businessName,
            'document_number' => $customerData->documentNumber,
            'contact_name' => $customerData->contactName,
            'phone_number' => $customerData->phoneNumber,
            'email' => $customerData->email,
            'address' => $customerData->address,
            'comments' => $customerData->comments,
        ]);

        return $customer;
    }
}
