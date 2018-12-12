<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function compareArrays($arrayOne, $arrayTwo) {
        $results = [];
        foreach($arrayOne as $key => $val) {
            if(isset($arrayTwo[$key])){
                if(is_array($val) && $arrayTwo[$key]){
                    $results[$key] = $this->compareArrays($val, $arrayTwo[$key]);
                }
            } else {
                $results[$key] = $val;
            }
        }

        foreach ($results as $index => $result) {
            if (empty($result)) {
                unset($results[$index]);
            }
        }

        return $results;
    }
}
