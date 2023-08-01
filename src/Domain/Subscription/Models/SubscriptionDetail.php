<?php

namespace Domain\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSubscriptionDetail
 */
class SubscriptionDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo<Subscription, SubscriptionDetail>
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
