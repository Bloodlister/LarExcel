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
     */
    public function linked_table_has_correctly_set_its_linked_fields_and_()
    {
        $table = new TableWithHeaders(new Row(['a', 'b', 'c']));
        $table->addRow(new AssocRow(['a', 'b', 'c'], ['a' => 3, 'b' => 4, 'c' => 5]));
        $linkedSpreadSheet = new Linked($table, ['a', 'b']);
        $this->assertEquals(['a', 'b'], $linkedSpreadSheet->getLinkingFields());
        $this->assertEquals(1, count($linkedSpreadSheet->getTables()));
    }

}