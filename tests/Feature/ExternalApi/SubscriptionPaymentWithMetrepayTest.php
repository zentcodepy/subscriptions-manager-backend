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

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3-1]->id);
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

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3-1]->id);
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

        $this->assertTrue($processedDTO->subscriptionDetail->id === $subscription2->details[3-1]->id);
        $this->assertTrue($processedDTO->status == SubscriptionDetailStatus::Pending);
    }
}
