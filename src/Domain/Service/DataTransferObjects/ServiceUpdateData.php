<?php

namespace Domain\Service\DataTransferObjects;

use Domain\Service\Helpers\ServiceStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceUpdateData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly int $customerId,
        public readonly string $state,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'customer_id' => ['required', 'integer'],
            'state' => [new Enum(ServiceStatus::class)],
        ];
    }
}