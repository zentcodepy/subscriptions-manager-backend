<?php

namespace Database\Factories;

use Carbon\Carbon;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use function fake;

/**
 * @extends Factory<SubscriptionDetail>
 */
class SubscriptionDetailFactory extends Factory
{
    protected $model = SubscriptionDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateFrom = Carbon::create(fake()->date());

        return [
            'subscription_id' => SubscriptionFactory::new()->create()->id,
            'status' => SubscriptionDetailStatus::Pending,
            'amount' => fake()->numberBetween('500000', '2000000'),
            'schedule_payment_date' => $dateFrom->addMonth(),
        ];
    }
}
