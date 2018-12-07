<?php

namespace App\Excel\Rows;

class Row extends Base {

    public function __construct(array $data) {
        $data = array_values($data);
        $this->data = $data;
    }

    public function getCurrentValue() {
        return $this->data[$this->currentIndex];
    }

    public function next() : Base {
        $this->currentIndex += 1;
        return $this;
    }
}