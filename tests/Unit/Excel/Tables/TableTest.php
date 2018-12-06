<?php
namespace Tests\Unit;

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
        $table->addRow([1, 2, 3]);
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

        $table->addRow([1]);
    }

}