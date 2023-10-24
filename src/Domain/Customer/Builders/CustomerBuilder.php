<?php

namespace Domain\Customer\Builders;

use Domain\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Customer>
 */
class CustomerBuilder extends Builder
{
    public function whereLikeBusinessNameOrDocumentNameOrContactName(?string $search): self
    {
        return $this->where(fn(CustomerBuilder $q) =>
            $q->when($search, fn(CustomerBuilder $q, $search) =>
                $q->where('business_name', 'like', "%$search%")
                    ->orWhere('document_number', 'like', "%$search%")
                    ->orWhere('contact_name', 'like', "%$search%")
            )
        );
    }

    public function whereLikeBusinessNameOrDocumentName(?string $search): self
    {
        return $this->where(fn(CustomerBuilder $q) =>
            $q->when($search, fn(CustomerBuilder $q, $search) =>
                $q->where('business_name', 'like', "%$search%")
                    ->orWhere('document_number', 'like', "%$search%")
            )
        );
    }

}
