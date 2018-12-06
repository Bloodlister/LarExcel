<?php

namespace App\Excel\Tables;

class TableWithHeaders extends Base {

    /**
     * It's one ahead because the first row is saved for the headers
     * @var int $currentRowIndex
     */
    protected $currentRowIndex = 1;

    /** @var array|String[] $tableHeaders Contains the names of each column in the  */
    private $tableHeaders;

    /**
     * Iterator constructor.
     * @param String[] $tableHeaders
     */
    public function __construct(array $tableHeaders) {
        $this->tableHeaders = $tableHeaders;
        $this->tableWidth = count($tableHeaders);
        $this->addRow($tableHeaders);
    }

    public function addRow($row) : Base {
        if ($this->validRow($row)) {
            $newRow = $this->formatRow($row);
            array_push($this->rows, $newRow);

            return $this;
        }
    }

    private function validRow(array $row) : bool {
        if (count($row) == $this->tableWidth) {
            return true;
        } else {
            throw new \Exception("Invalid row size");
        }
    }

    private function formatRow($row) {

        if (empty(array_diff($this->tableHeaders, array_keys($row)))) {
            return $row;
        } else {
            $newRow = [];
            foreach ($this->tableHeaders as $headerIndex => $tableHeader) {
                $newRow[$tableHeader] = $row[$headerIndex];
            }
            return $newRow;
        }
    }
}