<?php

namespace Tests\Unit;

use App\Excel\Rows\AssocRow;
use Tests\TestCase;

class AssocRowTest extends TestCase {

    /**
     * @test
     */
    public function assoc_row_returns_correct_value_when_called_for()
    {
        $row = new AssocRow(['foo', 'bar', 'zas'], [
            'foo' => 1,
            'bar' => 2,
            'zas' => 3,
        ]);

        $this->assertEquals(1, $row->getCurrentValue());
        $this->assertEquals(2, $row->next()->getCurrentValue());
        $this->assertEquals(3, $row->next()->getCurrentValue());
        $this->assertEquals(1, $row->getCurrentValue('foo'));
    }

    /**
     * @test
     */
    public function throws_exception_if_passed_incorrect_values_on_construct()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Empty Blueprint');

        new AssocRow([], [
            'asd' => 3
        ]);
    }

    /**
     * @test
     */
    public function throws_exception_when_trying_to_get_non_existing_value()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Non-existing field');

        $table = new AssocRow(['foo'], ['foo' => 5]);
        $table->getCurrentValue('bar');
    }
}