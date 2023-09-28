<?php

namespace Domain\Service\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceCreateData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $name,

        #[Required, IntegerType]
        public readonly int $customerId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }
}
