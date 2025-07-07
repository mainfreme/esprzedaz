<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\PetStatus;
use Illuminate\Validation\Rules\Enum;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\ArrayType;

class PetData extends Data
{
    #[Min(1)]
    public ?int $id = null;

    public ?CategoryData $category;

    #[Required, StringType]
    public string $name;

    #[Rule([
        'required',
        'array',
        'min:1',
    ])]
    #[ArrayType('string')]
    public array $photoUrls;

    /** @var TagData[] */
    #[Rule([
        'required',
        'array',
        'min:1',
    ])]
    #[ArrayType(TagData::class)]
    public array $tags;

    #[Rule(['required', new Enum(PetStatus::class)])]
    public string $status;

    public ?string $mainPhotoUrl;

    public function __construct(
        ?CategoryData $category,
        string $name,
        array $photoUrls,
        array $tags,
        string $status,
        ?int $id = null,
    ) {
        $this->category = $category;
        $this->name = $name;
        $this->photoUrls = $photoUrls;
        $this->tags = $tags;
        $this->status = $status;
        $this->mainPhotoUrl = $photoUrls[0] ?? null;
        $this->id = $id;
    }
}
