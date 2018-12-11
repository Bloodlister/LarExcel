<?php
namespace App\Excel\Tables;

use App\Excel\Rows\Base as Row;
use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Comparator;
use Ouzo\Utilities\Objects;

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


    /**
     * @return Base|bool
     */
    public function nextRow() {
        if ($this->currentRowIndex + 1 >= $this->getRowsCount()) {
            return false;
        }

        $this->currentRowIndex += 1;
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
//            var_dump($row, $row->getLength(), $this->tableWidth); exit();
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

    /**
     * @param $linkingValue
     * @return bool
     */
    public function containsValue($linkingValue) : Bool {
        $this->resetRowIndex();
        while ($this->nextRow()) {
            $rowData = $this->getRow()->getData();
            foreach ($linkingValue as $key => $value) {
                if (array_key_exists($key, $rowData) && $rowData[$key] == $value) {
                    return true;
                } else if (array_key_exists($key, $rowData) && $rowData[$key] != $value) {
                    break;
                }
            }
        }
        return false;
    }

    public function resetRowIndex() {
        $this->currentRowIndex = 0;
    }

}