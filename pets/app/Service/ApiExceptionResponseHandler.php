<?php

declare(strict_types=1);

namespace App\Service;

use Illuminate\Http\Client\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Exceptions\PayloadTooLargeException;

class ApiExceptionResponseHandler
{
    public static function handle(Response $response): void
    {
        $status = $response->status();

        if ($status === 400) {
            throw ValidationException::withMessages(['api' => 'Nieprawidłowe dane.']);
        }

        if ($status === 404) {
            throw new NotFoundHttpException('Zasób nie został znaleziony.');
        }

        if ($status === 405) {
            throw new MethodNotAllowedHttpException([], 'Metoda niedozwolona.');
        }

        if ($status === 413) {
            throw new PayloadTooLargeException('Plik jest za duży.');
        }

        $response->throw();
    }

    public static function wrap(\Throwable $e): void
    {
        report($e);
        throw new \RuntimeException('Usługa Pet Store jest obecnie niedostępna.');
    }
}
