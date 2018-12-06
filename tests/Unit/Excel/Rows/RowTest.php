<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Excel\Rows\Row;

class RowTest extends TestCase {

    /**
     * @test
     */
    public function row_returns_data_accordingly_to_how_it_was_passed_down()
    {
        $row = new Row([5, 2, 5, 1]);
        $this->assertEquals(5, $row->getCurrentValue());
        $this->assertEquals(2, $row->next()->getCurrentValue());
        $this->assertEquals(5, $row->next()->getCurrentValue());
        $this->assertEquals(1, $row->next()->getCurrentValue());
    }

}