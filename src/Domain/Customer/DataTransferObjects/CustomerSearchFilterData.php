<?php

namespace Domain\Customer\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CustomerSearchFilterData extends Data
{
    public function __construct(
        #[Nullable, Sometimes, StringType]
        public readonly ?string $search,
    ) {}
}
