<?php
namespace App\Excel\Tables;

use App\Excel\Rows\Base as Row;
use App\Excel\Rows\Factory;

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
    public function addRow($row) : Base {
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
     * @param $row
     * @return bool
     * @throws \Exception
     */
    private function validRow($row) {
        if (is_array($row)) {
            $row = Factory::createRowFromData($row);
        }
        if ($row->getLength() <= $this->tableWidth) {
            return true;
        }

        return false;
    }


}