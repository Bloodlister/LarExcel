<?php

namespace App\Excel\Rows;

class AssocRow extends Base {

    public function __construct(array $blueprint, array $data) {

    }

    public function getCurrentValue() {

    }

    public function next() : Base {
        return $this;
    }
}