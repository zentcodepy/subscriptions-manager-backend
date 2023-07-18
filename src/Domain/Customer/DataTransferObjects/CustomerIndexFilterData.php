<?php

namespace Domain\Customer\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CustomerIndexFilterData extends Data
{
    public function __construct(
        public readonly ?string $search,
    ) {}

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'search' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
