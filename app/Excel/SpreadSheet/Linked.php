<?php

namespace App\Excel\SpreadSheet;

use App\Excel\Rows\AssocRow;
use App\Excel\Tables\Base as Table;
use App\Excel\Tables\TableWithHeaders;

class Linked extends Base {

    protected $linkedFields = [];

    public function __construct($linkedFields) {
        $this->linkedFields = $linkedFields;
    }

    private function tableHasLinkedFields(TableWithHeaders $table) {
        $tableHeaders = $table->getHeaders();
        foreach ($this->linkedFields as $linkedField) {
            if (!in_array($linkedField, $tableHeaders)) {
                throw new \Exception("Table is missing linked field");
            }
        }
        return true;
    }

    public function getLinkingFields() {
        return $this->linkedFields;
    }

    /**
     * @param TableWithHeaders $table
     * @throws \Exception
     */
    protected function validateTable($table) {
        if (!($table instanceof TableWithHeaders)) {
            throw new \Exception('Linked table accepts only tables if type \App\Excel\Table\TableWithHeaders');
        }

        $tableHeaders = $table->getHeaders();
        foreach ($this->linkedFields as $linkedField) {
            if (!in_array($linkedField, $tableHeaders)) {
                throw new \Exception("Table is missing linked field: " . "'" . $linkedField . "'");
            }
        }
    }

    public function addTable(Table $table) {
        parent::addTable($table);
        $this->tableHasLinkedFields($table);
        $this->updateTables();
    }

    private function updateTables($defaultValues = []) {
        $this->addMissingLinkingValues($this->getAllLinkingValues(), $defaultValues);
    }

    private function getAllLinkingValues() {
        $linkedFieldsValues = [];
        foreach ($this->tables as $table) {
            $table->resetRowIndex();
            while ($table->nextRow()) {
                $rowData = $table->getRow()->getData();
                $record = [];
                foreach ($this->linkedFields as $field) {
                    $record[$field] = $rowData[$field];
                }
                $linkedFieldsValues[] = $record;
            }
        }

        return $linkedFieldsValues;
    }

    private function addMissingLinkingValues($linkingValues, $defaultValues) {
        foreach ($this->tables as $table) {
            foreach ($linkingValues as $linkingValue) {
                if (!$table->containsValue($linkingValue)) {
                    $table->addRow(new AssocRow($linkingValue));
                }
            }
        }
    }

}