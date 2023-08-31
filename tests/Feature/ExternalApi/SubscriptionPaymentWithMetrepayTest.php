<?php

namespace Tests\Feature\ExternalApi;

use App\Services\SubscriptionPayment\MetrepaySubscriptionPaymentStrategy;
use Database\Factories\SubscriptionDetailFactory;
use Database\Factories\SubscriptionFactory;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Tests\TestCase;

class SubscriptionPaymentWithMetrepayTest extends TestCase
{
    /** @test */
    public function metrepay_subscription_payment_strategy_calculate_correct_detail_id_and_status_payed()
    {
        SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        $subscription2 = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(6)->sequence(['amount' => 150000]), 'details')
            ->create(['duration_in_months' => 6, 'total_amount' => 900000]);

        $requestData = [
            'event' => 'PAYMENT_SUCCESS',
            'data' => [
                'txId' => 1000,
                'payRequestId' => 2000,
                'currency' => 'PYG',
                'amount' => 150000.00,
                'statusId' => 200,
                'customIdentifier' => $subscription2->id,
                'label' => 'Pago 3/12',
                'subscriptionTotalPeriods' => 6,
                'subscriptionPayedPeriod' => 3,
            ]
        ];

        $processedDTO = (new MetrepaySubscriptionPaymentStrategy())->processPaymentAttempt($requestData);

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3 - 1]->id);
        $this->assertTrue($processedDTO->status == SubscriptionDetailStatus::Payed);
    }

    /** @test */
    public function metrepay_subscription_payment_strategy_calculate_correct_detail_id_and_status_pending()
    {
        SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        $subscription2 = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(6)->sequence(['amount' => 150000]), 'details')
            ->create(['duration_in_months' => 6, 'total_amount' => 900000]);

        $requestData = [
            'event' => 'PAYMENT_SUCCESS',
            'data' => [
                'txId' => 1000,
                'payRequestId' => 2000,
                'currency' => 'PYG',
                'amount' => 150000.00,
                'statusId' => 5,
                'customIdentifier' => $subscription2->id,
                'label' => 'Pago 3/12',
                'subscriptionTotalPeriods' => 6,
                'subscriptionPayedPeriod' => 3,
            ]
        ];

        $processedDTO = (new MetrepaySubscriptionPaymentStrategy())->processPaymentAttempt($requestData);

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3 - 1]->id);
        $this->assertTrue($processedDTO->status == SubscriptionDetailStatus::Pending);
    }

    /** @test */
    public function metrepay_subscription_payment_strategy_calculate_correct_detail_id_and_status_pending_when_wrong_amount()
    {
        SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        $subscription2 = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(6)->sequence(['amount' => 150000]), 'details')
            ->create(['duration_in_months' => 6, 'total_amount' => 900000]);

        $requestData = [
            'event' => 'PAYMENT_SUCCESS',
            'data' => [
                'txId' => 1000,
                'payRequestId' => 2000,
                'currency' => 'PYG',
                'amount' => 200000.00,
                'statusId' => 200,
                'customIdentifier' => $subscription2->id,
                'label' => 'Pago 3/12',
                'subscriptionTotalPeriods' => 6,
                'subscriptionPayedPeriod' => 3,
            ]
        ];

        $processedDTO = (new MetrepaySubscriptionPaymentStrategy())->processPaymentAttempt($requestData);

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3 - 1]->id);
        $this->assertTrue($processedDTO->status == SubscriptionDetailStatus::Pending);
    }

    /** @test */
    public function metrepay_subscription_payment_endpoint_calculate_correct_detail_id_and_status_payed()
    {
        SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        $subscription2 = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(6)->sequence(['amount' => 150000]), 'details')
            ->create(['duration_in_months' => 6, 'total_amount' => 900000]);

        $requestData = [
            'event' => 'PAYMENT_SUCCESS',
            'data' => [
                'txId' => 1000,
                'payRequestId' => 2000,
                'currency' => 'PYG',
                'amount' => 150000.00,
                'statusId' => 200,
                'customIdentifier' => $subscription2->id,
                'label' => 'Pago 3/12',
                'subscriptionTotalPeriods' => 6,
                'subscriptionPayedPeriod' => 3,
            ]
        ];

        config()->set('metrepay.user', 'mp_user');
        config()->set('metrepay.password', 'mp_password');
        $headers = ['Authorization' => 'Basic ' . base64_encode( "mp_user:mp_password")];

        $response = $this->putJson(route('subscription-payments.metrepay-strategy'), $requestData, $headers);

        $response->assertStatus(200);

        $subscription2->refresh();

        $this->assertTrue($subscription2->details[3 - 1]->status === SubscriptionDetailStatus::Payed->value);
        $this->assertTrue($subscription2->details[3 - 1]->payed_at !== null);

    }

    /** @test */
    public function metrepay_subscription_payment_endpoint_calculate_correct_detail_id_and_status_pending_when_wrong_amount()
    {
        SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(10), 'details')
            ->create(['duration_in_months' => 10]);

        $subscription2 = SubscriptionFactory::new()
            ->has(SubscriptionDetailFactory::new()->count(6)->sequence(['amount' => 150000]), 'details')
            ->create(['duration_in_months' => 6, 'total_amount' => 900000]);

        $requestData = [
            'event' => 'PAYMENT_SUCCESS',
            'data' => [
                'txId' => 1000,
                'payRequestId' => 2000,
                'currency' => 'PYG',
                'amount' => 200000.00,
                'statusId' => 200,
                'customIdentifier' => $subscription2->id,
                'label' => 'Pago 3/12',
                'subscriptionTotalPeriods' => 6,
                'subscriptionPayedPeriod' => 3,
            ]
        ];

        config()->set('metrepay.user', 'mp_user');
        config()->set('metrepay.password', 'mp_password');
        $headers = ['Authorization' => 'Basic ' . base64_encode( "mp_user:mp_password")];

        $response = $this->putJson(route('subscription-payments.metrepay-strategy'), $requestData, $headers);

        $response->assertStatus(200);

        $response->assertStatus(200);

        $subscription2->refresh();

        $this->assertTrue($subscription2->details[3 - 1]->status === SubscriptionDetailStatus::Pending->value);
        $this->assertTrue($subscription2->details[3 - 1]->payed_at === null);

    }

    /** @test */
    public function metrepay_subscription_payment_endpoint_returns_401_if_empty_basic_auth_data_sent()
    {
        $response = $this->putJson(route('subscription-payments.metrepay-strategy'), []);

        $response->assertStatus(401);
    }

    /** @test */
    public function metrepay_subscription_payment_endpoint_returns_401_if_wrong_basic_auth_data_sent()
    {
        config()->set('metrepay.user', 'mp_user');
        config()->set('metrepay.password', 'mp_password');
        $headers = ['Authorization' => 'Basic ' . base64_encode( "mp_user1:mp_password2")];

        $response = $this->putJson(route('subscription-payments.metrepay-strategy'), [], $headers);

        $response->assertStatus(401);
    }
}
