<?php

namespace Tests\Unit\Data;

use App\Dto\PetDeletedResponseData;
use PHPUnit\Framework\TestCase;

class PetDeletedResponseDataTest extends TestCase
{
    /** @test */
    public function it_can_be_created_with_full_data()
    {
        $dto = new PetDeletedResponseData(
            status: 'success',
            message: 'Zwierzak został usunięty.',
            data: ['id' => 1234]
        );

        $this->assertEquals('success', $dto->status);
        $this->assertEquals('Zwierzak został usunięty.', $dto->message);
        $this->assertEquals(['id' => 1234], $dto->data);
    }

    /** @test */
    public function it_defaults_to_empty_data_array()
    {
        $dto = new PetDeletedResponseData(
            status: 'success',
            message: 'Zwierzak został usunięty.'
        );

        $this->assertEquals([], $dto->data);
    }

    /** @test */
    public function it_can_be_created_from_array()
    {
        $input = [
            'status' => 'success',
            'message' => 'Usunięto.',
            'data' => ['id' => 999],
        ];

        $dto = new PetDeletedResponseData(
            $input['status'],
            $input['message'],
            $input['data']
        );

        $this->assertEquals('success', $dto->status);
        $this->assertEquals('Usunięto.', $dto->message);
        $this->assertEquals(['id' => 999], $dto->data);
    }
}
