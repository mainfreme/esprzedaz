<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class CategoryData extends Data
{

    public function __construct(
        #[Required, IntegerType, Min(1)]
        public int $id,
        #[Required, StringType]
        public string $name
    )
    {
    }

    public static function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string'],
        ];
    }
}
