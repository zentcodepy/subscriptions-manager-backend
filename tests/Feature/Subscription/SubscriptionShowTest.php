<?php

namespace Tests\Feature\Subscription;

use Database\Factories\ServiceFactory;
use Database\Factories\SubscriptionDetailFactory;
use Database\Factories\SubscriptionFactory;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscriptionShowTest extends TestCase
{
    /** @test */
    public function can_get_subscription_data_by_id()
    {
        $this->login();

        $schedulePaymentDate = now()->format('Y-m-d');
        $payedAt = now()->addDays(2)->setMillisecond(0);

        $subscription = SubscriptionFactory::new()
            ->has(
                SubscriptionDetailFactory::new()->count(10)->sequence([
                    'amount' => 10000,
                    'status' => SubscriptionDetailStatus::Pending,
                    'schedule_payment_date' => $schedulePaymentDate,
                    'payed_at' => $payedAt,
                    'payment_info' => 'Test Info',
                ]),
                'details')
            ->create();

        $response = $this->getJson(route('subscriptions.show', ['subscription' => $subscription->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($subscription, $schedulePaymentDate, $payedAt) {
                $json->has('data', function (AssertableJson $json) use ($subscription, $schedulePaymentDate, $payedAt) {
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
                        'details' => 'array',
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
                    ->where('subscription_info', $subscription->subscription_info)
                    ->has('details', 10)
                    ->has('details.0', function(AssertableJson $json) use($schedulePaymentDate, $payedAt) {
                        $json->whereAllType([
                            'id' => 'integer',
                            'amount' => 'integer',
                            'status' => 'string',
                            'schedule_payment_date' => 'string',
                            'payed_at' => 'string',
                            'payment_info' => 'string',
                        ])
                        ->where('amount', 10000)
                        ->where('status', SubscriptionDetailStatus::Pending->value)
                        ->where('schedule_payment_date', $schedulePaymentDate)
                        ->where('payed_at', $payedAt->jsonSerialize())
                        ->where('payment_info', 'Test Info');
                    });
                });
            });
    }
}
