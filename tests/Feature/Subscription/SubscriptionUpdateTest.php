<?php

namespace Tests\Feature\Subscription;

use Database\Factories\SubscriptionFactory;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionUpdateTest extends TestCase
{
    /** @test */
    public function can_update_a_subscription()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()->create([
            'grace_period_in_days' => 10,
            'status' => SubscriptionStatus::Pending,
            'payment_service_type' => PaymentServiceTypes::Manual,
            'automatic_notification_enabled' => true,
            'subscription_info' => 'Info A',
        ]);


        $response = $this->putJson(route('subscriptions.update', ['subscription' => $subscription->id]), [
            'grace_period_in_days' => 5,
            'status' => SubscriptionStatus::Inactive,
            'payment_service_type' => PaymentServiceTypes::Metrepay,
            'automatic_notification_enabled' => false,
            'subscription_info' => 'Info B',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $subscription->refresh();

        $this->assertTrue($subscription->grace_period_in_days === 5);
        $this->assertTrue($subscription->status === SubscriptionStatus::Inactive->value);
        $this->assertTrue($subscription->payment_service_type === PaymentServiceTypes::Metrepay->value);
        $this->assertTrue($subscription->automatic_notification_enabled === 0);
        $this->assertTrue($subscription->subscription_info === 'Info B');
    }

    /** @test */
    public function fields_are_validated_when_try_to_update_a_subscription()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()->create();

        $response = $this->putJson(route('subscriptions.update', ['subscription' => $subscription->id]), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['grace_period_in_days', 'status', 'payment_service_type', 'automatic_notification_enabled']);
    }

}
