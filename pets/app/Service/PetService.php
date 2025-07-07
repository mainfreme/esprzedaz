<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PetDeletedResponseData;

class PetService
{
    public function __construct(
        private readonly PetApiClient $apiClient
    )
    {
    }

    public function deletePet(int $id): PetDeletedResponseData
    {
        try {
            $this->apiClient->deletePet($id);
            return PetDeletedResponseData::success($id);
        } catch (\HttpException $e) {
            return PetDeletedResponseData::error($e->getMessage());
        } catch (\Throwable $e) {
            return PetDeletedResponseData::error('Wystąpił nieoczekiwany błąd.');
        }
    }
}
