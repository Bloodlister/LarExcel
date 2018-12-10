<?php

namespace App\Excel\Tables;

use App\Excel\Rows\AssocRow;
use App\Excel\Rows\Factory;
use App\Excel\Rows\Base as RowBase;
use App\Excel\Rows\Row;

class TableWithHeaders extends Base {

    /**
     * It's one ahead because the first row is saved for the headers
     * @var int $currentRowIndex
     */
    protected $currentRowIndex = 0;

    /** @var array|String[] $tableHeader Contains the names of each column in the  */
    private $tableHeader;

    /**
     * Iterator constructor.
     * @param String[] $tableHeaders
     * @throws \Exception
     */
    public function __construct(Row $tableHeaders) {
        $this->tableHeader = $tableHeaders;
        $this->tableWidth = $tableHeaders->getLength();
        $this->addRow($tableHeaders);
    }

    public function addRow(RowBase $row) : Base {
        if ($this->validRow($row)) {
            $newRow = $this->formatRow($row);
            array_push($this->rows, $newRow);

            return $this;
        }
    }

    private function validRow($row) : bool {
        if (is_array($row)) {
            $row = Factory::createRowFromData($row);
        }
        if ($row->getLength() <= $this->tableWidth) {
            return true;
        } else {
            throw new \Exception("Invalid row size");
        }
    }

    private function formatRow(RowBase $row) {
        if (empty(array_diff($this->tableHeader->getData(), $row->getData()))) {
            return $row;
        } else {
            if ($row instanceof Row) {
                $newRow = [];
                $rowData = array_values($row->getData());
                foreach ($this->tableHeader->getData() as $headerIndex => $tableHeader) {
                    $newRow[$tableHeader] = $rowData[$headerIndex];
                }
                return new AssocRow($newRow);
            } else {
                foreach ($this->getHeaders() as $header) {
                    if (!array_key_exists($header, $row->getData())) {
                        $row->extend($header);
                    }
                }
                return $row;
            }
        }
    }

    public function getHeaders() {
        return $this->tableHeader->getData();
    }
}