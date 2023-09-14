<?php

namespace Domain\Subscription\Resources;

use Domain\Subscription\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SubscriptionShowResource
 *
 * @mixin Subscription
 * */
class SubscriptionShowResource extends JsonResource
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
            'service_id' => $this->service_id,
            'service_name' => $this->service->name,
            'customer_id' => $this->service->customer_id,
            'customer_name' => $this->service->customer->business_name,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'duration_in_months' => $this->duration_in_months,
            'grace_period_in_days' => $this->grace_period_in_days,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'payment_service_type' => $this->payment_service_type,
            'automatic_notification_enabled' => $this->automatic_notification_enabled === 1,
            'subscription_info' => $this->subscription_info,
            'details' => SubscriptionDetailShowResource::collection($this->details),
        ];
    }
}
