<?php

declare(strict_types=1);

namespace App\Enums;

enum PetStatus: string {
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function values()
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Dostępne',
            self::PENDING => 'Oczekujące',
            self::SOLD => 'Sprzedane',
        };
    }
}
