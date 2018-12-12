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
        foreach ($arrayCollection as $index => $array) {
            $arrayCollection[$index] = $this->fillArrayWithFields($array, $fields);
        }
        return $arrayCollection;
    }

    /**
     * @param       $arrayOfItems
     * @param array $fieldsArray Fields which should be added to the $arrayOfItems
     * @param int   $defaultForMissing
     * @return array
     */
    private function fillArrayWithFields($arrayOfItems, $fieldsArray, $defaultForMissing = 0){
        $blueprint = [];
        $fieldsWithNoMatches = []; //Fields which did not find a match
        foreach ($arrayOfItems as $item) { // Looping through all the items in the array
            if (!$blueprint) {
                $blueprint = array_keys($item);
            }
            $hitCount = 0; // This is used to decide if all the current fields are in the array already
            foreach ($fieldsArray as $index => $fields) { // Looping through all the fields
                foreach ($fields as $key => $field) {
                    //If the items key value from the fields is equal increment the hit count
                    if ($item[$key] == $field) {
                        $hitCount++;
                    } else { // If it's not a match restart the hit counter and break the loop
                        $hitCount = 0;
                        break;
                    }
                }

                //If there is the same amount as matches as there are number of fields in fields
                //Remove the field from $fieldsWithNoMatches if the field is in it
                //Remove the field from the $fieldsArray so that
                if ($hitCount == count($fields)) {
                    if (in_array($fields, $fieldsWithNoMatches)) {
                        unset($fieldsWithNoMatches[array_search($fields, $fieldsWithNoMatches)]);
                    }
                    unset($fieldsArray[$index]);
                    continue;
                }

                if ($hitCount != count($fields)) {
                    if (!in_array($fields, $fieldsWithNoMatches)) {
                        $fieldsWithNoMatches[] = $fields;
                    }
                }
            }
        }
        foreach ($fieldsWithNoMatches as $match) {
            foreach ($blueprint as $key) {
                if (!array_key_exists($key, $match)) {
                    $match[$key] = $defaultForMissing;
                }
            }
            $arrayOfItems[] = $match;
        }
        return $arrayOfItems;
    }
    
}