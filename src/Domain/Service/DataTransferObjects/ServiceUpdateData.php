<?php

namespace Domain\Service\DataTransferObjects;

use Domain\Service\Helpers\ServiceStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Symfony\Contracts\Service\Attribute\Required;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceUpdateData extends Data
{
    public function __construct(
        #[Nullable, Sometimes, StringType]
        public readonly ?int $id,

        #[Required, StringType]
        public readonly string $name,

        #[Required, IntegerType]
        public readonly int $customerId,

        #[Required, Enum(ServiceStatus::class)]
        public readonly string $status,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }
}
