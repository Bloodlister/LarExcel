<?php

namespace Tests\Unit;

use App\Excel\Tables\TableWithHeaders;
use Tests\TestCase;

class TableWithHeadersTest extends TestCase {

    /** @var TableWithHeaders $table */
    private $table;

    protected function setUp() {
        parent::setUp();
        $this->table = new TableWithHeaders(['foo', 'bar', 'zas']);
    }

    /** 
     * @test 
     */
    public function created_table_has_correct_width_according_to_headers_count()
    {
        $table = new TableWithHeaders(['Foo', 'Bar', 'Zas']);
        $this->assertEquals(3, $table->getTableWidth());
        $this->assertEquals(1, $table->getRowsCount());
    }

    /**
     * @test
     */
    public function adding_non_assoc_array_row_to_table()
    {
        $this->table->addRow([1, 2, 3]);
        $tableRow = $this->table->nextRow()->nextRow()->getRowData();
        $this->assertEquals([
            'foo' => 1,
            'bar' => 2,
            'zas' => 3
        ], $tableRow);
    }

    /**
     * @test
     */
    public function adding_assoc_array_row_to_table()
    {
        $this->table->addRow([
            'foo' => 1,
            'zas' => 3,
            'bar' => 2,
        ]);
        $tableRow = $this->table->nextRow()->nextRow()->getRowData();
        $this->assertEquals([
            'foo' => 1,
            'bar' => 2,
            'zas' => 3,
        ], $tableRow);
    }

}