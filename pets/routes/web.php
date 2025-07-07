<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Enums\PetStatus;

Route::get('/{status?}', [PetController::class, 'index'])
    ->defaults('status', 'available')
    ->where('status', implode('|', array_column(PetStatus::cases(), 'value')))
    ->name('pets.index');

Route::get('/detail/{id}', [PetController::class, 'detail'])
    ->name('pets.detail');

Route::get('/create', [PetController::class, 'create'])
    ->name('pets.create');
Route::post('/store', [PetController::class, 'store'])
    ->name('pets.store');



Route::get('/edit/{id}', [PetController::class, 'edit'])
    ->name('pets.edit');
Route::put('/update/{id}', [PetController::class, 'update'])
    ->name('pets.update');


Route::delete('/destroy/{status}/{id}', [PetController::class, 'destroy'])
    ->name('pets.destroy');



Route::get('/detail/{petId}', [PetController::class, 'show'])
    ->name('pets.show');



Route::get('/pets/{id}/upload-image', [PetController::class, 'uploadImageForm'])
    ->name('pets.upload-image-form');
Route::post('/pets/{id}/upload-image', [PetController::class, 'uploadImage'])
    ->name('pets.upload-image');
