<?php

namespace Domain\Customer\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CustomerData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $businessName,
        public readonly ?string $documentNumber,
        public readonly ?string $contactName,
        public readonly ?string $phoneNumber,
        public readonly ?string $email,
        public readonly ?string $address,
        public readonly ?string $comments,
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
            'business_name' => ['required', 'string'],
            'document_number' => ['nullable', 'sometimes', 'string'],
            'contact_name' => ['nullable', 'sometimes', 'string'],
            'phone_number' => ['nullable', 'sometimes', 'string'],
            'email' => ['nullable', 'sometimes', 'email'],
            'address' => ['nullable', 'sometimes', 'string'],
            'comments' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
