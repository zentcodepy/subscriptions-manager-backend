<?php

namespace App\Services\SubscriptionPayment;

use App\Services\SubscriptionPayment\DataTransferObjects\ProcessedSubscriptionPaymentData;
use App\Services\SubscriptionPayment\Interfaces\SubscriptionPaymentStrategy;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;

class MetrepaySubscriptionPaymentStrategy implements SubscriptionPaymentStrategy
{
    /**
     * @param array<string, mixed> $data
     */
    public function processPaymentAttempt(array $data): ProcessedSubscriptionPaymentData
    {
        $subscriptionId = $data['customIdentifier'];
        $periodPayed = $data['subscriptionPayedPeriod'];
        $amount = $data['amount'];
        $statusId = $data['statusId'];

        return new ProcessedSubscriptionPaymentData(
            $this->getSubscriptionDetailId($subscriptionId, $periodPayed, $amount),
            $this->getStatus($statusId),
            $this->getPaymentInfo($data),
        );
    }

    private function getSubscriptionDetailId(int $subscriptionId, int $periodPayed, int $amount): int
    {
        //todo: obtain and validate the subscription detail id
        return $subscriptionId;
    }

    private function getStatus(int $statusId): SubscriptionDetailStatus
    {
        //todo: review
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
        return "Pagado por Metrepay: " . json_encode($data);
    }
}
