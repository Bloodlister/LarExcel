<?php

namespace App\Excel\SpreadSheet;

use App\Excel\Tables\TableWithHeaders;
use Complex\Exception;

class Linked extends Base {

    protected $linkedFields = [];

    public function __construct(TableWithHeaders $table, $linkedFields) {
        $this->linkedFields = $linkedFields;
        if ($this->tableHasLinkedFields($table, $linkedFields)) {
            $this->addTable($table);
        }
    }

    private function tableHasLinkedFields(TableWithHeaders $table) {
        $tableHeaders = $table->getHeaders();
        if (!empty(array_diff($tableHeaders, $this->linkedFields))) {
            throw new Exception('Table is missing linked field');
        }

    }

}