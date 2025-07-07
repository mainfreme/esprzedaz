<?php

namespace App\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class TagData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $name,

        public readonly ?int $id = null,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'min:1'],
            'name' => ['required', 'string'],
        ];
    }
}
