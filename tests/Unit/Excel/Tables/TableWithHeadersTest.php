<?php

namespace Tests\Unit;

use App\Excel\Rows\Row;
use App\Excel\Rows\AssocRow;
use App\Excel\Tables\TableWithHeaders;
use Tests\TestCase;

class TableWithHeadersTest extends TestCase {

    /** @var TableWithHeaders $table */
    private $table;

    protected function setUp() {
        parent::setUp();
        $this->table = new TableWithHeaders(new Row(['foo', 'bar', 'zas']));
    }

    /** 
     * @test 
     */
    public function created_table_has_correct_width_according_to_headers_count()
    {
        $table = new TableWithHeaders(new Row(['Foo', 'Bar', 'Zas']));
        $this->assertEquals(3, $table->getTableWidth());
        $this->assertEquals(1, $table->getRowsCount());
    }

    /**
     * @test
     */
    public function adding_non_assoc_array_row_to_table()
    {
        $this->table->addRow(new Row([1, 2, 3]));
        $tableRow = $this->table->nextRow()->getRow()->getData();
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
        $this->table->addRow(new AssocRow([
            'foo' => 1,
            'zas' => 3,
            'bar' => 2,
        ]));
        $tableRow = $this->table->nextRow()->getRow()->getData();
        $this->assertEquals([
            'foo' => 1,
            'bar' => 2,
            'zas' => 3,
        ], $tableRow);
    }

}