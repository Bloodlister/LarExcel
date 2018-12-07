<?php
namespace Tests\Unit;

use App\Excel\Rows\Row;
use App\Excel\Tables\TableHeadless;
use Tests\TestCase;

class TableTest extends TestCase {
    /** 
     * @test 
     */
    public function created_table_has_correct_width()
    {
        $table = new TableHeadless(3);

        $this->assertEquals(3, $table->getTableWidth());
        return $table;
    }

    /**
     * @test
     * @depends created_table_has_correct_width
     * @param TableHeadless $table
     * @throws \Exception
     */
    public function adding_row_to_table(TableHeadless $table)
    {
        $table->addRow(new Row([1, 2, 3]));
        $this->assertEquals(1, $table->getRowsCount());
    }

    /**
     * @test
     * @depends created_table_has_correct_width
     * @param TableHeadless $table
     * @throws \Exception
     */
    public function adding_row_with_incorrect_size_throws_an_exception(TableHeadless $table)
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Incorrect row size');

        $table->addRow(new Row([1, 5, 2, 1, 2]));
    }

    /**
     * @test
     */
    public function adding_smaller_row_that_width_fills_row_with_null() {
        $table = new TableHeadless(2);
        $row = new Row([1]);
        $table->addRow($row);
        $this->assertEquals([1, null], $table->getRow()->getData());
    }

}