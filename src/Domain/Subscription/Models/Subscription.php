<?php

namespace Domain\Subscription\Models;

use Domain\Service\Models\Service;
use Domain\Subscription\Builders\SubscriptionBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_from' => 'date:Y-m-d',
        'date_to' => 'date:Y-m-d',
    ];
    
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

    /**
     * @return HasMany<SubscriptionDetail>
     */
    public function details(): HasMany
    {
        return $this->hasMany(SubscriptionDetail::class);
    }
}
