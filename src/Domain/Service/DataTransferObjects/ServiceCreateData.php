<?php

namespace Domain\Service\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceCreateData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly int $customerId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::from($request->all());
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'customer_id' => ['required', 'integer'],
        ];
    }
}
