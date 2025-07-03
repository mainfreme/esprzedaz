<?php

declare(strict_types=1);

namespace App\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\ArrayType;

class PetData extends Data
{
    #[Required, Min(0)]
    public int $id;

    #[Required]
    public CategoryData $category;

    #[Required, StringType]
    public string $name;

    #[Required, ArrayType('string')]
    public array $photoUrls;

    #[Required, ArrayType(TagData::class)]
    public array $tags;

    #[Required, StringType]
    public string $status;

    public function __construct(
        int $id,
        CategoryData $category,
        string $name,
        array $photoUrls,
        array $tags,
        string $status
    ) {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->photoUrls = $photoUrls;
        $this->tags = $tags;
        $this->status = $status;
    }
}
