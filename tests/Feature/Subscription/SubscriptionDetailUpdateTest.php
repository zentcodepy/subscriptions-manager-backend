<?php

namespace Tests\Feature\Subscription;

use Database\Factories\SubscriptionDetailFactory;
use Database\Factories\SubscriptionFactory;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionDetailUpdateTest extends TestCase
{
    /** @test */
    public function can_update_subscription_detail_status_to_canceled()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        /** @var SubscriptionDetail $subscriptionDetail */
        $subscriptionDetail = $subscription->details()->first();

        $response = $this->putJson(route('subscription-details.update', ['subscription_detail' => $subscriptionDetail->id]), [
            'status' => SubscriptionDetailStatus::Canceled,
            'payment_info' => 'Did not pay',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $subscriptionDetail->refresh();

        $this->assertTrue($subscriptionDetail->status === SubscriptionDetailStatus::Canceled->value);
        $this->assertTrue($subscriptionDetail->payment_info === 'Did not pay');
        $this->assertNull($subscriptionDetail->payed_at);
    }

    /** @test */
    public function can_update_subscription_detail_status_to_pending()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->sequence(['status' => SubscriptionDetailStatus::Canceled])->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        /** @var SubscriptionDetail $subscriptionDetail */
        $subscriptionDetail = $subscription->details()->first();

        $response = $this->putJson(route('subscription-details.update', ['subscription_detail' => $subscriptionDetail->id]), [
            'status' => SubscriptionDetailStatus::Pending,
            'payment_info' => 'Is pending',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $subscriptionDetail->refresh();

        $this->assertTrue($subscriptionDetail->status === SubscriptionDetailStatus::Pending->value);
        $this->assertTrue($subscriptionDetail->payment_info === 'Is pending');
        $this->assertNull($subscriptionDetail->payed_at);
    }

    /** @test */
    public function can_update_subscription_detail_status_to_payed()
    {
        $this->login();

        $subscription = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        /** @var SubscriptionDetail $subscriptionDetail */
        $subscriptionDetail = $subscription->details()->first();

        $response = $this->putJson(route('subscription-details.update', ['subscription_detail' => $subscriptionDetail->id]), [
            'status' => SubscriptionDetailStatus::Payed,
            'payment_info' => 'Payed with cash',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $subscriptionDetail->refresh();

        $this->assertTrue($subscriptionDetail->status === SubscriptionDetailStatus::Payed->value);
        $this->assertTrue($subscriptionDetail->payment_info === 'Payed with cash');

        //when comparing dates, delta is in seconds
        $this->assertEqualsWithDelta(now(), $subscriptionDetail->payed_at, 5);

    }
}
