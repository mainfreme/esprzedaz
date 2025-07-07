<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PetData;
use App\Dto\UploadPetImageData;
use App\Enums\PetStatus;
use App\Support\ApiDataValidator;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Validation\ValidationException;

class PetApiClient
{
    protected string $baseUrl;

    public function __construct(protected Http $http)
    {
        $this->baseUrl = config('services.petstore.base_url');
    }

    /**
     * Pobiera zwierzęta na podstawie statusu z zewnętrznego API.
     *
     * @param PetStatus $status
     * @return Collection
     * @throws ConnectionException
     * @throws Exception
     */
    public function findPetsByStatus(PetStatus $status): Collection
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->get('/pet/findByStatus', ['status' => $status->value]);

            ApiExceptionResponseHandler::handle($response);

            return collect($response->json())->map(function ($item) {
                try {
                    return PetData::from($item);
                } catch (\Throwable $e) {
                    report($e);
                    return null;
                }
            })->filter();

        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }

    public function findPet(int $petId): PetData
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->get("/pet/{$petId}")
                ->throw();

            ApiExceptionResponseHandler::handle($response);

            $data = $response->json();

            ApiDataValidator::validate($data, ['name', 'category', 'status', 'photoUrls', 'tags']);

            return PetData::from($data);

        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }

    public function deletePet(int $petId): void
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->delete("/pet/{$petId}");

            ApiExceptionResponseHandler::handle($response);
        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }

    public function addPet(PetData $petData): PetData
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->post("/pet", $petData->toArray());

            ApiExceptionResponseHandler::handle($response);

            $rawData = json_decode($response->body(), true);
            return PetData::from($rawData);

        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }

    public function updatePet(PetData $petData): PetData
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->withBody($petData->toJson(), 'application/json')
                ->put('/pet');

            ApiExceptionResponseHandler::handle($response);

            $rawData = json_decode($response->body(), true);

            ApiDataValidator::validate($rawData, ['name', 'category', 'status', 'photoUrls', 'tags']);

            return PetData::from($rawData);
        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }

    public function uploadImage(UploadPetImageData $data): void
    {
        try {
            $response = $this->http
                ->baseUrl($this->baseUrl)
                ->attach(
                    'file',
                    fopen($data->file->getPathname(), 'r'),
                    $data->file->getClientOriginalName()
                )
                ->attach(
                    'additionalMetadata',
                    $data->additionalMetadata ?? ''
                )
                ->post("/pet/{$data->id}/uploadImage");

            ApiExceptionResponseHandler::handle($response);

        } catch (RequestException|ValidationException $e) {
            ApiExceptionResponseHandler::wrap($e);
        }
    }
}
