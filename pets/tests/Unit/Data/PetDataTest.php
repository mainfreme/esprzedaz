<?php

declare(strict_types=1);

namespace Tests\Unit\Data;

use App\Dto\PetData;

use App\Dto\CategoryData;
use App\Dto\TagData;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PetDataTest extends TestCase
{
    public function testCategoryOnNull(): void
    {
        $this->expectException(\TypeError::class);

        try {
            PetData::validateAndCreate([
                'id'        => 1,
                'category'  => null,
                'name'      => 'Name',
                'photoUrls' => ['url'],
                'tags'      => [['id' => 1, 'name' => 'nazwa']],
                'status'    => 'available',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();

            $this->assertArrayHasKey('category', $errors);
            $this->assertStringContainsString('required', $errors['category']);

            throw $e;
        }
    }

    public function testTagsEmpty(): void
    {
        $this->expectException(ValidationException::class);

        try {
            PetData::validateAndCreate([
                'id'        => 1,
                'category'  => ['id' => 1, 'name' => 'nazwa'],
                'name'      => 'Name',
                'photoUrls' => ['url'],
                'tags'      => [],
                'status'    => 'available',
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();

            $this->assertArrayHasKey('tags', $errors);
            $this->assertStringContainsString('required', $errors['tags'][0]);

            throw $e;
        }
    }

    public function testThrowsOnNegativeId(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessageMatches('/id.*at least 0/');

        PetData::validateAndCreate([
            'id'        => -1,
            'category'  => ['id' => 1, 'name' => 'nazwa'],
            'name'      => 'Name',
            'photoUrls' => ['url'],
            'tags'      => [['id' => 1, 'name' => 'nazwa']],
            'status'    => 'available',
        ]);
    }
}
