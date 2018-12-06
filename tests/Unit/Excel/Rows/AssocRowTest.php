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
}