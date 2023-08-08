<?php

namespace Domain\Subscription\DataTransferObjects;

use Carbon\Carbon;
use Domain\Subscription\Helpers\SubscriptionDetailStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\GreaterThan;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SubscriptionDetailCreateData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public readonly int $subscriptionId,

        #[Required, IntegerType, GreaterThan('0')]
        public readonly int $amount,

        #[Required, Enum(SubscriptionDetailStatus::class)]
        public readonly string $status,

        #[Required, WithCast(DateTimeInterfaceCast::class)]
        public readonly Carbon $schedulePaymentDate,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }

}
