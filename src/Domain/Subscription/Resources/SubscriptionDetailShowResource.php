<?php

namespace Domain\Subscription\Resources;

use Domain\Subscription\Models\SubscriptionDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SubscriptionShowResource
 *
 * @mixin SubscriptionDetail
 * */
class SubscriptionDetailShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'schedule_payment_date' => $this->schedule_payment_date,
            'payed_at' => $this->payed_at,
            'payment_info' => $this->payment_info,
        ];
    }
}
