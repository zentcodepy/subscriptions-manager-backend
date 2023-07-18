<?php

namespace Domain\Customer\Actions;

use Domain\Customer\Models\Customer;

class DeleteCustomerAction
{
    public function __invoke(Customer $customer): ?bool
    {
        return $customer->delete();
    }
}
