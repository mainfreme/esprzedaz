<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;

class UploadPetImageData extends Data
{
    public function __construct(
        #[Required]
        public int $id,

        #[Nullable]
        public ?string $additionalMetadata,

        #[Nullable, Mimes('jpg', 'jpeg', 'png'), Max(5120)]
        public ?UploadedFile $file,
    ) {
    }
}
