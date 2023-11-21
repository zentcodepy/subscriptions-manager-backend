<?php

namespace Domain\Subscription\Actions;

use Carbon\Carbon;
use Domain\Subscription\DataTransferObjects\SubscriptionCreateData;
use Domain\Subscription\DataTransferObjects\SubscriptionDetailCreateData;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Domain\Subscription\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateSubscriptionAction
{
    public function __construct(
        private CalculateDateToFromDateFromAndDurationInMonthsAction
            $calculateDateToFromDateFromAndDurationInMonthsAction
    )
    {}

    /**
     * @throws Throwable
     */
    public function __invoke(SubscriptionCreateData $subscriptionData): Subscription
    {
        DB::beginTransaction();

        try {
            $subscription = $this->saveSubscription($subscriptionData);

            $this->saveDetails($subscription);

            DB::commit();

            return $subscription;
        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    private function saveSubscription(SubscriptionCreateData $subscriptionData): Subscription
    {
        return Subscription::create([
            'service_id' => $subscriptionData->serviceId,
            'date_from' => $subscriptionData->dateFrom,
            'duration_in_months' => $subscriptionData->durationInMonths,
            'date_to' => ($this->calculateDateToFromDateFromAndDurationInMonthsAction)($subscriptionData->dateFrom, $subscriptionData->durationInMonths),
            'status' => SubscriptionStatus::Pending,
            'total_amount' => $subscriptionData->totalAmount,
            'grace_period_in_days' => $subscriptionData->gracePeriodInDays,
            'payment_service_type' => $subscriptionData->paymentServiceType,
            'automatic_notification_enabled' => $subscriptionData->automaticNotificationEnabled,
            'subscription_info' => $subscriptionData->subscriptionInfo,
        ]);
    }

    private function saveDetails(Subscription $subscription): void
    {
        collect()->range(1, $subscription->duration_in_months)->each(function($period) use ($subscription) {
            $data = new SubscriptionDetailCreateData(
                $subscription->id,
                (new CalculateSubscriptionDetailAmountAction)(
                    $subscription->total_amount,
                    $subscription->duration_in_months),
                SubscriptionDetailStatus::Pending->value,
                (new CalculateSubscriptionDetailSchedulePaymentDateAction)(
                    $subscription->date_from,
                    $period
                ),
            );
            (new CreateSubscriptionDetailAction)($data);
        });
    }
}
