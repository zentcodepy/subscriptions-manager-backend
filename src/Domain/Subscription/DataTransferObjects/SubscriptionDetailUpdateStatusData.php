<?php

namespace Domain\Subscription\DataTransferObjects;

use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SubscriptionDetailUpdateStatusData extends Data
{
    public function __construct(
        #[Required, Enum(SubscriptionDetailStatus::class)]
        public readonly SubscriptionDetailStatus $status,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $paymentInfo,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }

}
