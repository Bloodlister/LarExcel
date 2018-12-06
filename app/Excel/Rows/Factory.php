<?php

namespace App\Excel\Rows;

class Factory {

    public static function createRowFromData($rowData) : Base {
        $rowKeys = array_keys($rowData);

        foreach ($rowKeys as $rowKey) {
            if (!is_numeric($rowKey)) {
                return new Row($rowData);
            }
        }

        return new AssocRow($rowKeys, $rowData);
    }

}