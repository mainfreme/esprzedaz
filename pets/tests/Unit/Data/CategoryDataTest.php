<?php

namespace Tests\Unit\Data;

use App\Dto\CategoryData;
use Tests\TestCase;

use Spatie\LaravelData\Exceptions\CannotCreateData;

class CategoryDataTest extends TestCase
{

    /** @test */
    public function testItFailsWhenIdIsMissing()
    {
        $this->expectException(CannotCreateData::class);

        CategoryData::from([
            'name' => 'Missing id'
        ]);

    }

    /** @test */
    public function testItFailsWhenNameIsMissing()
    {
        $this->expectException(CannotCreateData::class);

        CategoryData::from(['id' => 150]);
    }

    /** @test */
    public function testItCreatesTagDataWithValidInput()
    {
        $data = [
            'id' => 1,
            'name' => 'Test category',
        ];

        $tag = CategoryData::from($data);

        $this->assertEquals(1, $tag->id);
        $this->assertEquals('Test category', $tag->name);
    }
}
