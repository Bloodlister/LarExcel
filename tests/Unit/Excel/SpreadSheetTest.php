<?php

namespace Tests\Unit;

use App\Excel\SpreadSheet\SpreadSheet;
use App\Excel\Tables\TableHeadless;
use Tests\TestCase;

class SpreadSheetTest extends TestCase {

    /**
     * @test
     */
    public function spreadsheet_accepts_tables()
    {
        $spreadSheet = new SpreadSheet();
        $table = new TableHeadless(2);
        $table->addRow(['a', 'b']);
        $table->addRow(['b', 'c']);
        $spreadSheet->addTable($table);
        $this->assertEquals(1, count($spreadSheet->getTables()));

        return $spreadSheet;
    }

    /**
     * @test
     * @depends spreadsheet_accepts_tables
     * @param SpreadSheet $spreadSheet
     * @throws \Exception
     */
    public function tables_in_spreadsheet_get_their_starting_coordinates_set_correctly(SpreadSheet $spreadSheet)
    {
        $table = new TableHeadless(2);
        $table->addRow(['c', 'd']);
        $table->addRow(['b', 's']);
        $spreadSheet->addTable($table);

        $newTable = clone $table;
        $newTable->setMargin(2);
        $spreadSheet->addTable($newTable);


        $newTable = clone $table;
        $newTable->setMargin(0);
        $spreadSheet->addTable($newTable);

        $startCoordsOfFirstTable = [
            ['startX' => 1, 'endX' => 2],
            ['startX' => 4, 'endX' => 5],
            ['startX' => 8, 'endX' => 9],
            ['startX' => 10, 'endX' => 11],
        ];

        $tables = $spreadSheet->getTables();
        foreach ($tables as $index => $table) {
            $this->assertEquals($startCoordsOfFirstTable[$index]['startX'], $table->getStartX());
            $this->assertEquals($startCoordsOfFirstTable[$index]['endX'], $table->getEndX());
        }
    }

}