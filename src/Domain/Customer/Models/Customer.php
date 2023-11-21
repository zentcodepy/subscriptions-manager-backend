<?php

namespace Domain\Customer\Models;

use Domain\Customer\Builders\CustomerBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): CustomerBuilder
    {
        return new CustomerBuilder($query);
    }
}
