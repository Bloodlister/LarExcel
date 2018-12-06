<?php
namespace App\Excel\Tables;

abstract class Base {
    /** @var int $width */
    protected $tableWidth;

    /** @var array $rows */
    protected $rows = [];

    /** @var int $currentRowIndex */
    protected $currentRowIndex = 0;

    /**
     * Base constructor.
     * @param int $tableWidth
     */
    public function __construct(int $tableWidth) {
        $this->tableWidth = $tableWidth;
    }

    /**
     * @return int
     */
    public function getTableWidth() : int {
        return $this->tableWidth;
    }


    /**
     * @param array $row
     * @return Base
     * @throws \Exception
     */
    public function addRow(array $row) : Base {
        if (count($row) == $this->tableWidth) {
            array_push($this->rows, $row);
        } else {
            throw new \Exception("Incorrect row size");
        }

        return $this;
    }

    /**
     * Gets the amount of rows
     * @return int
     */
    public function getRowsCount() : int {
        return count($this->rows);
    }


    public function nextRow() : Base {
        $this->currentRowIndex += 1;
        if ($this->currentRowIndex >= $this->getRowsCount()) {
            $this->currentRowIndex = $this->getRowsCount() - 1;
        }
        return $this;
    }

    public function getRowData() : array {
        return $this->rows[$this->currentRowIndex];
    }
}