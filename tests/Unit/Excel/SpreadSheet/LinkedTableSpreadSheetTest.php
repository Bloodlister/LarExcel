<?php

namespace Tests\Unit;

use App\Excel\Rows\AssocRow;
use App\Excel\Rows\Row;
use App\Excel\SpreadSheet\Linked;
use App\Excel\Tables\TableWithHeaders;
use Tests\TestCase;

class LinkedTableSpreadSheetTest extends TestCase {

    /**
     * @test
     * @throws \Exception
     */
    public function linked_table_has_correctly_set_its_linked_fields()
    {
        $linkedSpreadSheet = new Linked(['a', 'b']);
        $table = new TableWithHeaders(new Row(['a', 'b', 'c']));
        $table->addRow(new AssocRow(['a' => 3, 'b' => 4, 'c' => 5]));
        $linkedSpreadSheet->addTable($table);
        $this->assertEquals(['a', 'b'], $linkedSpreadSheet->getLinkingFields());
        $this->assertEquals(1, count($linkedSpreadSheet->getTables()));

        return $linkedSpreadSheet;
    }

    /**
     * @test
     * @depends linked_table_has_correctly_set_its_linked_fields
     * @param Linked $spreadSheet
     * @throws \Exception
     */
    public function linked_table_throws_exception_if_table_is_missing_a_linked_field(Linked $spreadSheet)
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Table is missing linked field: 'b'");

        $table = new TableWithHeaders(new Row(['a', 'c']));
        $spreadSheet->addTable($table);
    }

    /**
     * @test
     * @depends linked_table_has_correctly_set_its_linked_fields
     * @param Linked $spreadSheet
     * @return Linked
     * @throws \Exception
     */
    public function adding_new_table_updates_previous_tables_adding_missing_fields(Linked $spreadSheet)
    {
        $table = new TableWithHeaders(new Row(['a', 'b', 'c']));
        $table->addRow(new AssocRow(['a' => 4, 'b' => 5, 'c' => 5]));
        $spreadSheet->addTable($table);

        $spreadSheetTable = $spreadSheet->getTables()[0];
        $this->assertEquals(3, $spreadSheetTable->getRowsCount());
        $spreadSheetTable->resetRowIndex();
        $this->assertEquals(['a' => 3, 'b' => 4, 'c' => 5], $spreadSheetTable->nextRow()->getRow()->getData());
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => null], $spreadSheetTable->nextRow()->getRow()->getData());
        $this->assertEquals(false, $spreadSheetTable->nextRow());

        $secondTable = $spreadSheet->getTables()[1];
        $this->assertEquals(3, $secondTable->getRowsCount());
        $secondTable->resetRowIndex();
        $this->assertEquals(['a' => 3, 'b' => 4, 'c' => null], $secondTable->nextRow()->getRow()->getData());
        $this->assertEquals(['a' => 4, 'b' => 5, 'c' => 5], $secondTable->nextRow()->getRow()->getData());
        $this->assertEquals(false, $secondTable->nextRow());

        return $spreadSheet;
    }

}