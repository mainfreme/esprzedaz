<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'status' => $this->resource->status,
            'category' => [
                'id' => $this->resource->category->id,
                'name' => $this->resource->category->name,
            ],
            'photoUrls' => $this->resource->photoUrls ?? [],
            'main_photo_url' => $this->resource->photoUrls[0] ?? null,
            'tags' => $this->resource->tags,
        ];
    }
}
