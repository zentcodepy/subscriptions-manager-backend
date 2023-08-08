<?php

namespace Domain\Service\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceIndexFilterData extends Data
{
    public function __construct(
        public readonly ?int $customerId,
        public readonly ?string $name,
        public readonly ?string $status,
    ) {}

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'customer_id' => ['nullable', 'sometimes', 'integer'],
            'name' => ['nullable', 'sometimes', 'string'],
            'status' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
