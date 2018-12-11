<?php

namespace App\Helpers;

class Equalizer {

    public static function equalize($arrayCollection, $fields) {
        $equalizer = new self();
        $fieldRecords = $equalizer->getAllFieldRecords($arrayCollection, $fields);
        $matchedArray = $equalizer->matchArrays($arrayCollection, $fieldRecords);
        return $matchedArray;
    }

    private function getAllFieldRecords($arrayCollection, $fields) {
        $fieldRecords = [];

        foreach ($arrayCollection as $array) {
            foreach ($array as $item) {
            $record = [];
                foreach ($fields as $field) {
                    $record[$field] = $item[$field];
                }

                if (!in_array($record, $fieldRecords)) {
                    $fieldRecords[] = $record;
                }
            }
        }

        return $fieldRecords;
    }

    private function matchArrays($arrayCollection, $fields) {
        
    }
    
}