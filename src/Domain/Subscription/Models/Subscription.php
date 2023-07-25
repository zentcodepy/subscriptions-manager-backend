<?php

namespace Domain\Subscription\Models;

use Domain\Service\Models\Service;
use Domain\Subscription\Builders\SubscriptionBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): SubscriptionBuilder
    {
        return new SubscriptionBuilder($query);
    }

    /**
     * @return BelongsTo<Service, Subscription>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
