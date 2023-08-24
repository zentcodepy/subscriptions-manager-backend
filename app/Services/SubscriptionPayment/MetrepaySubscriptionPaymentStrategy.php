<?php

namespace App\Services\SubscriptionPayment;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;
use App\Services\SubscriptionPayment\Interfaces\SubscriptionPaymentStrategy;
use Domain\Subscription\Actions\GetSubscriptionDetailByPeriodAction;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Domain\Subscription\Models\SubscriptionDetail;

class MetrepaySubscriptionPaymentStrategy implements SubscriptionPaymentStrategy
{
    /**
     * @param array<string, mixed> $data
     */
    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData
    {
        $subscriptionId = $data['data']['customIdentifier'];
        $periodPayed = $data['data']['subscriptionPayedPeriod'];
        $amount = intval(round($data['data']['amount']));
        $statusId = $data['data']['statusId'];

        $subscriptionDetail = $this->getSubscriptionDetail($subscriptionId, $periodPayed);

        return new ProcessedSubscriptionPaymentData(
            $subscriptionDetail,
            $this->getStatus($statusId, $amount, $subscriptionDetail),
            $this->getPaymentInfo($data),
        );
    }

    private function getSubscriptionDetail(int $subscriptionId, int $periodPayed): SubscriptionDetail
    {
        return (new GetSubscriptionDetailByPeriodAction)($subscriptionId, $periodPayed);
    }

    private function getStatus(int $statusId, int $amount, SubscriptionDetail $subscriptionDetail): SubscriptionDetailStatus
    {
        if($amount != $subscriptionDetail->amount) {
            return SubscriptionDetailStatus::Pending;
        }

        return match ($statusId) {
            200 => SubscriptionDetailStatus::Payed,
            default => SubscriptionDetailStatus::Pending,
        };
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getPaymentInfo(array $data): string
    {
        return "Datos recibidos de Metrepay: " . json_encode($data);
    }
}
