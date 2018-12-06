<?php

namespace App\Excel\Rows;

class AssocRow extends Base {

    /** @var array $headers */
    private $headers = [];
    /** @var string $currentHeader */
    private $currentHeader = null;

    public function __construct(array $blueprint, array $data) {
        if (count($blueprint) > 0) {
            $this->headers = array_values($blueprint);
            $this->currentHeader = $this->headers[0];
            $this->data = $data;
        } else {
            throw new \Exception("Empty Blueprint");
        }
    }

    public function getCurrentValue($field = null) {
        if ($field != null && isset($this->data[$field])) {
            return $this->data[$field];
        } else if ($field != null && !isset($this->data[$field])) {
            throw new \Exception('Non-existing field');
        } else {
            return $this->data[$this->getCurrentHeader()];
        }
    }

    public function getCurrentHeader() {
        return $this->headers[$this->currentIndex];
    }

    public function next() : Base {
        $this->currentIndex += 1;
        $this->currentHeader = $this->headers[0];

        return $this;
    }
}