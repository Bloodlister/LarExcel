<?php

namespace App\Excel\Rows;

abstract class Base {
    protected $data = [];

    protected $currentIndex = 0;

    abstract public function getCurrentValue();

    abstract public function next() : Base;
}