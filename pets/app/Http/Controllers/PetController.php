<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\PetData;
use App\Dto\UploadPetImageData;
use App\Enums\PetStatus;
use App\Http\Resources\PetResource;
use App\Service\PetService;
use App\Service\PetApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PetController extends Controller
{

    public function __construct(
        private readonly PetService $petService,
        protected PetApiClient      $petApiClient
    )
    {
    }


    public function index(PetStatus $status)
    {
        try {
            $petsCollection = $this->petApiClient->findPetsByStatus($status);

            $pets = PetResource::collection($petsCollection);

            return view('pets.index', [
                'pets' => $pets,
                'currentStatus' => $status->value,
            ]);

        } catch (\Exception $e) {
            return view('errors.pet-api-error', [
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function destroy(string $status, int $id): RedirectResponse
    {
        $responseData = $this->petService->deletePet($id);

        return redirect()
            ->route('pets.index', ['status' => $status])
            ->with($responseData->status, $responseData->message);
    }

    public function detail(int $id)
    {
        try {
            $petData = $this->petApiClient->findPet($id);
            $pet = new PetResource($petData);

            return view('pets.detail', [
                'pet' => $pet,
                'title' => 'Szczegóły zwierzęcia'
            ]);

        } catch (\Exception $e) {
            return view('errors.pet-api-error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function create()
    {
        return view('pets.form', []);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $petData = PetData::from($request->all());
            $responsePetData = $this->petApiClient->addPet($petData);

            return redirect()
                ->route('pets.detail', ['id' => $responsePetData->id])
                ->with('success', 'Zwierzak dodany!');
        } catch (\Spatie\LaravelData\Exceptions\InvalidDataClass $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function edit(int $id)
    {
        try {
            $petData = $this->petApiClient->findPet($id);

            $pet = new PetResource($petData);

            return view('pets.form', [
                'pet' => $pet
            ]);

        } catch (\Exception $e) {
            return view('errors.pet-api-error', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        try {
            $petData = PetData::from([...$request->all(), 'id' => $id]);

            $responsePetData = $this->petApiClient->updatePet($petData);

            return redirect()
                ->route('pets.detail', ['id' => $responsePetData->id])
                ->with('success', 'Zwierzak poprawnie zaktualizowany!');
        } catch (\Spatie\LaravelData\Exceptions\InvalidDataClass $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }


    public function uploadImageForm(int $id)
    {
        return view('pets.upload-image-form', ['id' => $id]);
    }

    /**
     * @throws \Exception
     */
    public function uploadImage(Request $request, int $id): RedirectResponse
    {

        try {
            $data = UploadPetImageData::from([...$request->all(), 'id' => $id]);
            $this->petApiClient->uploadImage($data);

            return redirect()
                ->route('pets.detail', ['id' => $id])
                ->with('success', 'Zdjęcie zostało przesłane.');

        }  catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\RuntimeException $e) {
            return back()
                ->withErrors(['file' => $e->getMessage()])
                ->withInput();
        }
    }

}
