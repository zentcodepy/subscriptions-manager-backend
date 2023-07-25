<?php

namespace Domain\Subscription\DataTransferObjects;

use Carbon\Carbon;
use Domain\Subscription\Helpers\PaymentServiceTypes;
use Domain\Subscription\Helpers\SubscriptionStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\GreaterThan;
use Spatie\LaravelData\Attributes\Validation\GreaterThanOrEqualTo;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class SubscriptionCreateData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public readonly int $serviceId,

        #[Required, WithCast(DateTimeInterfaceCast::class)]
        public readonly Carbon $dateFrom,

        #[Required, IntegerType, GreaterThan('0')]
        public readonly int $durationInMonths,

        #[Required, Enum(SubscriptionStatus::class)]
        public readonly string $status,

        #[Required, IntegerType, GreaterThan('0')]
        public readonly int $totalAmount,

        #[Required, IntegerType, GreaterThanOrEqualTo('0')]
        public readonly int $gracePeriodInDays,

        #[Required, Enum(PaymentServiceTypes::class)]
        public readonly string $paymentServiceType,

        #[Required, BooleanType]
        public readonly bool $automaticNotificationEnabled,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $subscriptionInfo,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }

}
