<?php

namespace App\Excel\SpreadSheet;

use App\Excel\Tables\Base as Table;

abstract class Base {

    /** @var Table[] $tables */
    protected $tables = [];

    protected $endOfLastTable = 1;

    public function addTable(Table $table) {
        if (empty($this->tables)) {
            $table->setStartX(1);
            $this->endOfLastTable = $table->getTableWidth();
        } else {
            $table->setStartX($this->endOfLastTable + $table->getMargin() + 1);
            $this->endOfLastTable += $table->getMargin() + $table->getTableWidth();
        }

        $this->tables[] = $table;
    }

    public function  getTables() {
        return $this->tables;
    }
}