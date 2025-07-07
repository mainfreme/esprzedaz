<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Data;

class PetAddResponseData extends Data
{
    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly ?int $id,
    )
    {
    }

    public static function success(int $id): self
    {
        return new self(status: 'success', message: 'Zwierzak został poprawnie dodany.', id: $id);
    }

    public static function error(string $message): self
    {
        return new self(status: 'error', message: $message, id: null);
    }
}
