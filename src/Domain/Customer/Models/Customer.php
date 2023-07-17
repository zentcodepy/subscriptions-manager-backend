<?php

namespace Domain\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCustomer
 */
class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];
}
