<?php
namespace App\Excel\Tables;

use App\Excel\Rows\Base as Row;

abstract class Base {
    /** @var int $width */
    protected $tableWidth;

    /** @var int $rightMargin */
    protected $rightMargin = 1;

    /** @var int $startX column at which the table starts */
    protected $startX = 0;

    /** @var int $endX column at which the table ends */
    protected $endX = 0;

    /** @var Row[] $rows */
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
     * @param array|Row $row
     * @return Base
     * @throws \Exception
     */
    public function addRow(Row $row) : Base {
        $this->formatRow($row);

        if ($this->validRow($row)) {
            array_push($this->rows, $row);
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

    public function getRow() : Row {
        return $this->rows[$this->currentRowIndex];
    }

    public function getStartX() {
        return $this->startX;
    }

    public function setStartX($x) {
        $this->startX = $x;
        $this->setEndX();
    }

    public function getEndX() {
        return $this->endX;
    }

    private function setEndX() {
        $this->endX = $this->startX + $this->getTableWidth() - 1;
    }

    public function setMargin($margin) {
        $this->rightMargin = $margin;
    }

    public function getMargin() {
        return $this->rightMargin;
    }

    /**
     * @param Row $row
     * @return bool
     * @throws \Exception
     */
    private function validRow(Row $row) : bool {
        if ($row->getLength() <= $this->tableWidth) {
            return true;
        } else {
            throw new \Exception('Incorrect row size');
        }

        return false;
    }

    /**
     * @param Row $row
     */
    private function formatRow(Row $row) {
        if ($row->getLength() < $this->getTableWidth()) {
            while ($row->getLength() < $this->getTableWidth()) {
                $row->extend();
            }
        }
    }


}