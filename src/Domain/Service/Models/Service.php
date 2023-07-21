<?php

namespace Domain\Service\Models;

use Domain\Customer\Models\Customer;
use Domain\Service\Builders\ServiceBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperService
 */
class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): ServiceBuilder
    {
        return new ServiceBuilder($query);
    }

    /**
     * @return BelongsTo<Customer, Service>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
