<?php

namespace Domain\Customer\Builders;

use Domain\Customer\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Customer>
 */
class CustomerBuilder extends Builder
{
    public function whereBusinessNameOrDocumentNameOrContactNameLike(string $search): self
    {
        return $this->where(fn(CustomerBuilder $q) =>
            $q->where('business_name', 'like', "%$search%")
                ->orWhere('document_name', 'like', "%$search%")
                ->orWhere('contact_name', 'like', "%$search%")
        );
    }

}
