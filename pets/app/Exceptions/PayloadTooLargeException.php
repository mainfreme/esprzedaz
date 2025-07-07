<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PayloadTooLargeException extends HttpException
{
    public function __construct(string $message = 'Plik jest za duży.', \Throwable $previous = null)
    {
        parent::__construct(413, $message, $previous);
    }
}
