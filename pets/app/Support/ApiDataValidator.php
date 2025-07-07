<?php

declare(strict_types=1);

namespace App\Support;

use UnexpectedValueException;

class ApiDataValidator
{
    public static function validate(array $data, array $requiredKeys): void
    {
        if (empty($data)) {
            throw new UnexpectedValueException('API zwróciło pustą odpowiedź.');
        }

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data) || empty($data[$key])) {
                throw new UnexpectedValueException("Brakuje danych w polu: {$key}");
            }
        }
    }
}

