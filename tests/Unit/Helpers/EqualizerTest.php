<?php

namespace Tests\Unit;

use App\Helpers\Equalizer;
use Tests\TestCase;

class EqualizerTest extends TestCase {

    /**
     * @test
     */
    public function equalizing_two_arrays()
    {
        $testArray = [[
            ['a' => 1, 'b' => 2, 'c' => 3],
            ['a' => 2, 'b' => 3, 'c' => 4],
        ], [
            ['a' => 1, 'b' => 2, 'c' => 0],
            ['a' => 3, 'b' => 4, 'c' => 5],
            ['a' => 4, 'b' => 5, 'c' => 6],
        ]];

        $result = Equalizer::equalize($testArray, ['a', 'b']);

        $this->assertEquals([
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                ['a' => 2, 'b' => 3, 'c' => 4],
                ['a' => 3, 'b' => 4, 'c' => 0],
                ['a' => 4, 'b' => 5, 'c' => 0],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 0],
                ['a' => 2, 'b' => 3, 'c' => 0],
                ['a' => 3, 'b' => 4, 'c' => 5],
                ['a' => 4, 'b' => 5, 'c' => 6],
            ]
        ], $result);
    }

}