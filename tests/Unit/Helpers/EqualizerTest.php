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
        ], [
            ['a' => 2, 'b' => 2, 'c' => 2],
            ['a' => 4, 'b' => 4, 'c' => 5],
        ]];

        $result = Equalizer::equalize($testArray, ['a', 'b']);
        $answers = [
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                ['a' => 2, 'b' => 3, 'c' => 4],
                ['a' => 3, 'b' => 4, 'c' => 0],
                ['a' => 4, 'b' => 5, 'c' => 0],
                ['a' => 2, 'b' => 2, 'c' => 0],
                ['a' => 4, 'b' => 4, 'c' => 0],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 0],
                ['a' => 2, 'b' => 3, 'c' => 0],
                ['a' => 3, 'b' => 4, 'c' => 5],
                ['a' => 4, 'b' => 5, 'c' => 6],
                ['a' => 2, 'b' => 2, 'c' => 0],
                ['a' => 4, 'b' => 4, 'c' => 0],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 0],
                ['a' => 2, 'b' => 3, 'c' => 0],
                ['a' => 3, 'b' => 4, 'c' => 0],
                ['a' => 4, 'b' => 5, 'c' => 0],
                ['a' => 2, 'b' => 2, 'c' => 2],
                ['a' => 4, 'b' => 4, 'c' => 5],
            ]
        ];

        foreach ($result as $index => $array) {
            $this->assertEmpty($this->compareArrays($answers[$index], $array));
        }
    }

    /**
     * @test
     */
    public function filling_in_array_with_fields()
    {
        $array = [
            ['a' => 1, 'b' => 2,'c' => 3]
        ];

        $equalizer = new Equalizer();
        $method = (new \ReflectionObject($equalizer))->getMethod('fillArrayWithFields');
        $method->setAccessible(true);
        $result = $method->invoke($equalizer, $array, [['a' => 1, 'b' => 2], ['a' => 2, 'b' => 1], ['a' =>3, 'b' => 4]]);

        $this->assertEquals([
            ['a' => 1, 'b' => 2, 'c' => 3],
            ['a' => 2, 'b' => 1, 'c' => 0],
            ['a' => 3, 'b' => 4, 'c' => 0],
        ], $result);
    }

    /**
     * @test
     */
    public function filling_in_array_by_string_fields()
    {
        $array = [
            [1 => 'Foo', 2 => 2, 3 => 3]
        ];


        $equalizer = new Equalizer();
        $method = (new \ReflectionObject($equalizer))->getMethod('fillArrayWithFields');
        $method->setAccessible(true);
        $result = $method->invoke($equalizer, $array, [[1 => 'Foo', 2 => 2], [1 => 'Bar', 2 => 3], [1 => 'Foo', 2 => 4]]);

        $this->assertEquals([
            [1 => "Foo", 2 => 2, 3 => 3],
            [1 => "Bar", 2 => 3, 3 => 0],
            [1 => "Foo", 2 => 4, 3 => 0],
        ], $result);
    }

}