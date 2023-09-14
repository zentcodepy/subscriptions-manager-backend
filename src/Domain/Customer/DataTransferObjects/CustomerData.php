<?php

namespace Domain\Customer\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CustomerData extends Data
{
    public function __construct(
        public readonly ?int $id,

        #[Required, StringType]
        public readonly string $businessName,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $documentNumber,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $contactName,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $phoneNumber,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $email,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $address,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $comments,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }
}
