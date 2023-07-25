<?php

namespace Tests\Feature\Subscription;

use Database\Factories\ServiceFactory;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Domain\Subscription\Models\Subscription;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionStoreTest extends TestCase
{
    /** @test */
    public function can_create_a_subscription()
    {
        $service = ServiceFactory::new()->create();

        $this->login();

        $response = $this->postJson(route('subscriptions.store'), [
            'service_id' => $service->id,
            'date_from' => '2023-01-15',
            'duration_in_months' => 6,
            'status' => SubscriptionStatus::Pending,
            'total_amount' => 450000,
            'grace_period_in_days' => 10,
            'payment_service_type' => PaymentServiceTypes::Manual,
            'automatic_notification_enabled' => true,
            'subscription_info' => 'Test info',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue(Subscription::query()
            ->where('service_id', $service->id)
            ->where('status', SubscriptionStatus::Pending->value)
            ->whereDate('date_from', '=', '2023-01-15')
            ->whereDate('date_to', '2023-07-14')
            ->exists());
    }

}
