<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class CategoryData extends Data
{

    public function __construct(
        #[Required, StringType]
        public string $name,
        public ?int $id = null,
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
