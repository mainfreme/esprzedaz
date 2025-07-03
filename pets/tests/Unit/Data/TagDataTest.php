<?php

namespace Tests\Unit\Data;

use Spatie\LaravelData\Exceptions\CannotCreateData;
use Tests\TestCase;
use App\Dto\TagData;

class TagDataTest extends TestCase
{

    /** @test */
    public function test_it_fails_when_id_is_missing()
    {
            $this->expectException(CannotCreateData::class);

            TagData::from([
                'name' => 'Missing id'
            ]);

    }

    /** @test */
    public function test_it_fails_when_name_is_missing()
    {
        $this->expectException(CannotCreateData::class);

        TagData::from(['id' => 1]);
    }

    /** @test */
    public function it_accepts_unicode_or_special_characters_in_name()
    {
        $data = TagData::from([
            'id' => 1,
            'name' => 'Łódź & Żubr 🦄',
        ]);

        $this->assertEquals('Łódź & Żubr 🦄', $data->name);
    }

    /** @test */
    public function it_creates_tag_data_with_valid_input()
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
    public function it_fails_when_id_is_missing()
    {
        $this->expectException(CannotCreateData::class);

        TagData::from([
            'name' => 'Missing id',
        ]);
    }
}
