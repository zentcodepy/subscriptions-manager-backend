<?php

namespace Domain\Subscription\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SubscriptionIndexFilterData extends Data
{
    public function __construct(
        public readonly ?string $status,
        public readonly ?int $serviceId,
    ) {}

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'status' => ['nullable', 'sometimes', 'string'],
            'service_id' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
