<?php

namespace Tests\Unit\Data;

use Spatie\LaravelData\Exceptions\CannotCreateData;
use Tests\TestCase;
use App\Dto\TagData;

class TagDataTest extends TestCase
{
    /** @test */
    public function testItFailsWhenNameIsMissing()
    {
        $this->expectException(CannotCreateData::class);

        TagData::from(['id' => 1]);
    }

    /** @test */
    public function testItAcceptsUnicodeOrSpecialCharactersInName()
    {
        $data = TagData::from([
            'id' => 1,
            'name' => 'Łódź & Żubr 🦄',
        ]);

        $this->assertEquals('Łódź & Żubr 🦄', $data->name);
    }

    /** @test */
    public function testItCreatesTagDataWithValidInput()
    {
        $data = [
            'id' => 1,
            'name' => 'Test Tag',
        ];

        $tag = TagData::from($data);

        $this->assertEquals(1, $tag->id);
        $this->assertEquals('Test Tag', $tag->name);
    }

    /** @test */
    public function testItFailsWhenIdIsMissing()
    {
        $this->expectException(CannotCreateData::class);

        TagData::from([
            'name' => 'Missing id',
        ]);
    }
}
