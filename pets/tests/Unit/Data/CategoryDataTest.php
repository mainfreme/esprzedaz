<?php

namespace Tests\Unit\Data;

use App\Dto\CategoryData;
use Tests\TestCase;

use Spatie\LaravelData\Exceptions\CannotCreateData;

class CategoryDataTest extends TestCase
{

    /** @test */
    public function test_it_fails_when_id_is_missing()
    {
        $this->expectException(CannotCreateData::class);

        CategoryData::from([
            'name' => 'Missing id'
        ]);

    }

    /** @test */
    public function test_it_fails_when_name_is_missing()
    {
        $this->expectException(CannotCreateData::class);

        CategoryData::from(['id' => 150]);
    }

    /** @test */
    public function it_creates_tag_data_with_valid_input()
    {
        $data = [
            'id' => 1,
            'name' => 'Test category',
        ];

        $tag = CategoryData::from($data);

        $this->assertEquals(1, $tag->id);
        $this->assertEquals('Test category', $tag->name);
    }

    /** @test */
    public function it_fails_when_id_is_missing()
    {
        $this->expectException(CannotCreateData::class);

        CategoryData::from([
            'name' => 'Missing id',
        ]);
    }
}
