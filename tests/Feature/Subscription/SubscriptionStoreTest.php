<?php

namespace Tests\Feature\Subscription;

use Database\Factories\ServiceFactory;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Domain\Subscription\Models\Subscription;
use Domain\Subscription\Models\SubscriptionDetail;
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
            ->where('date_from', '2023-01-15')
            ->where('duration_in_months', 6)
            ->where('date_to','2023-07-14')
            ->where('status', SubscriptionStatus::Pending->value)
            ->where('total_amount', 450000)
            ->where('grace_period_in_days', 10)
            ->where('payment_service_type', PaymentServiceTypes::Manual->value)
            ->where('automatic_notification_enabled', true)
            ->where('subscription_info', 'Test info')
            ->exists());
    }

    public function a_subscription_create_details_with_correct_data()
    {
        $service = ServiceFactory::new()->create();

        $this->login();

        $response = $this->postJson(route('subscriptions.store'), [
            'service_id' => $service->id,
            'date_from' => '2023-01-15',
            'duration_in_months' => 3,
            'status' => SubscriptionStatus::Pending,
            'total_amount' => 450000,
            'grace_period_in_days' => 10,
            'payment_service_type' => PaymentServiceTypes::Manual,
            'automatic_notification_enabled' => true,
            'subscription_info' => 'Test info',
        ]);

        /** @var Subscription $subscription */
        $subscription = Subscription::query()->first();

        $this->assertTrue($subscription->details()->count() == 3);

        /** @var SubscriptionDetail $detail1 */
        $detail1 = $subscription->details()->orderBy('id')->first();
        /** @var SubscriptionDetail $detail2 */
        $detail2 = $subscription->details()->orderBy('id')->skip(1)->first();
        /** @var SubscriptionDetail $detail3 */
        $detail3 = $subscription->details()->orderBy('id')->skip(2)->first();

        $this->assertTrue($detail1->amount == 150000);
        $this->assertTrue($detail1->status == SubscriptionDetailStatus::Pending->value);
        $this->assertTrue($detail1->schedule_payment_date == '2023-01-15');

        $this->assertTrue($detail2->amount == 150000);
        $this->assertTrue($detail2->status == SubscriptionDetailStatus::Pending->value);
        $this->assertTrue($detail2->schedule_payment_date == '2023-02-15');

        $this->assertTrue($detail3->amount == 150000);
        $this->assertTrue($detail3->status == SubscriptionDetailStatus::Pending->value);
        $this->assertTrue($detail3->schedule_payment_date == '2023-03-15');
    }

}
