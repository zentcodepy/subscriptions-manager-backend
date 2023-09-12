<?php

namespace Tests\Feature\Subscription;

use Database\Factories\ServiceFactory;
use Database\Factories\SubscriptionFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionShowTest extends TestCase
{
    /** @test */
    public function can_get_subscription_data_by_id()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()->create();

        $response = $this->getJson(route('subscriptions.show', ['subscription' => $subscription->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($subscription) {
                $json->has('data', function (AssertableJson $json) use ($subscription) {
                    $json->whereAllType([
                        'id'=> 'integer',
                        'service_id' => 'integer',
                        'service_name' => 'string',
                        'customer_id' => 'integer',
                        'customer_name' => 'string',
                        'date_from' => 'string',
                        'date_to' => 'string',
                        'duration_in_months' => 'integer',
                        'grace_period_in_days' => 'integer',
                        'total_amount' => 'integer',
                        'status' => 'string',
                        'payment_service_type' => 'string',
                        'automatic_notification_enabled' => 'boolean',
                        'subscription_info' => 'string',
                    ])
                    ->where('id', $subscription->id)
                    ->where('service_id', $subscription->service_id)
                    ->where('service_name', $subscription->service->name)
                    ->where('customer_id', $subscription->service->customer_id)
                    ->where('customer_name', $subscription->service->customer->business_name)
                    ->where('date_from', $subscription->date_from->jsonSerialize())
                    ->where('date_to', $subscription->date_to->jsonSerialize())
                    ->where('duration_in_months', $subscription->duration_in_months)
                    ->where('grace_period_in_days', $subscription->grace_period_in_days)
                    ->where('total_amount', $subscription->total_amount)
                    ->where('status', $subscription->status->value)
                    ->where('payment_service_type', $subscription->payment_service_type->value)
                    ->where('automatic_notification_enabled', $subscription->automatic_notification_enabled)
                    ->where('subscription_info', $subscription->subscription_info);
                });
            });
    }
}
