<?php

namespace Tests\Feature\Subscription;

use Database\Factories\ServiceFactory;
use Database\Factories\SubscriptionFactory;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionIndexTest extends TestCase
{
    /** @test */
    public function index_return_paginated_subscriptions()
    {
        SubscriptionFactory::new()->count(25)->create();
        $this->login();

        $response = $this->getJson(route('subscriptions.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function(AssertableJson $json) {
                $json
                    ->has('data', 20) //20 data because of pagination
                    ->has('meta')
                    ->has('links')
                    ->has('data.0', function(AssertableJson $json) {
                        $json->whereAllType([
                            'id' => 'integer',
                            'service_name' => 'string',
                            'date_from' => 'string',
                            'date_to' => 'string',
                            'duration_in_months' => 'integer',
                            'grace_period_in_days' => 'integer',
                            'total_amount' => 'integer',
                            'status' => 'string',
                            'payment_service_type' => 'string',
                            'automatic_notification_enabled' => 'boolean',
                        ]);
                    });
            });
    }

    /** @test */
    public function index_return_filtered_subscriptions_by_status()
    {
        SubscriptionFactory::new()->count(4)
            ->sequence(
                ['status' => SubscriptionStatus::Active],
                ['status' => SubscriptionStatus::Pending],
                ['status' => SubscriptionStatus::Inactive],
                ['status' => SubscriptionStatus::Active],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('subscriptions.index', ['status' => SubscriptionStatus::Active]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }


    /** @test */
    public function index_return_filtered_subscriptions_by_service_id()
    {
        [$service1, $service2] = ServiceFactory::new()->count(2)->create();

        SubscriptionFactory::new()->count(6)
            ->sequence(
                ['service_id' => $service1->id],
                ['service_id' => $service2->id],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('subscriptions.index', ['service_id' => $service1->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 3)->etc());
    }

    /** @test */
    public function index_return_filtered_subscriptions_by_status_and_service_id()
    {
        [$service1, $service2] = ServiceFactory::new()->count(2)->create();

        SubscriptionFactory::new()->count(6)
            ->sequence(
                ['status' => SubscriptionStatus::Active, 'service_id' => $service1->id],
                ['status' => SubscriptionStatus::Pending, 'service_id' => $service1->id],
                ['status' => SubscriptionStatus::Pending, 'service_id' => $service1->id],
                ['status' => SubscriptionStatus::Pending, 'service_id' => $service2->id],
                ['status' => SubscriptionStatus::Active, 'service_id' => $service2->id],
                ['status' => SubscriptionStatus::Inactive, 'service_id' => $service2->id],
            )
            ->create();

        $this->login();

        $response = $this->getJson(route('subscriptions.index', [
            'status' => SubscriptionStatus::Pending,
            'service_id' => $service1->id,
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 2)->etc());
    }
}
