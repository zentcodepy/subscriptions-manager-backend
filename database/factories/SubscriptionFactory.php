<?php

namespace Database\Factories;

use Carbon\Carbon;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Domain\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateFrom = fake()->date();
        $durationInMonths = fake()->numberBetween(1, 12);

        return [
            'service_id' => ServiceFactory::new()->create()->id,
            'date_from' => $dateFrom,
            'duration_in_months' => $durationInMonths,
            'date_to' => Carbon::create($dateFrom)->addMonths($durationInMonths)->format('Y-m-d'),
            'total_amount' => fake()->numberBetween('500000', '2000000'),
            'grace_period_in_days' => fake()->numberBetween(0, 10),
            'status' => fake()->randomElement([SubscriptionStatus::Pending, SubscriptionStatus::Inactive, SubscriptionStatus::Active]),
            'payment_service_type' => fake()->randomElement([PaymentServiceTypes::Manual, PaymentServiceTypes::Metrepay]),
            'automatic_notification_enabled' => fake()->boolean(),
            'subscription_info' => fake()->text(50),
        ];
    }
}
