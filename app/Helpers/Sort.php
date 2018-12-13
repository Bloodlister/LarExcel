<?php

namespace App\Helpers;

use Ouzo\Utilities\Arrays;
use Ouzo\Utilities\Comparator;

class Sort {

    public static function sortMultipleArrays(array $arrays, array $compoundFunctions) {
        foreach ($arrays as $index => $array) {
            $arrays[$index] = Arrays::sort($array, Comparator::compound(...$compoundFunctions));
        }

        return $arrays;
    }

}