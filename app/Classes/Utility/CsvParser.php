<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 11/06/2023
 * Time: 17:30
 */

namespace App\Classes\Utility;


class CsvParser
{
    /**
     * Parses an open csv file handler with the possibility to split columns and values
     * Keep in mind that both column and values should be split for the returned array to be valid
     */
    static public function parseFileWithHeaders($csvFile, $columnsToSplit=array(), $valuesToSplit=array()) {
        $headerData = fgetcsv($csvFile, 500, ",");
        if (count($columnsToSplit) > 0) {
            $temp = array();
            for ($i = 0; $i < count($headerData); $i++) {
                if (array_key_exists($i, $columnsToSplit)) {
                    foreach (explode($columnsToSplit[$i], $headerData[$i]) AS $item) {
                        $temp[] = ucfirst(trim($item));
                    }
                } else {
                    $temp[] = trim($headerData[$i]);
                }
            }
            $headerData = $temp;
        }
        $csv = array();
        while (($row = fgetcsv($csvFile, 500, ",")) !== FALSE) {
            if (count($valuesToSplit) > 0) {
                $temp = array();
                for ($i = 0; $i < count($row); $i++) {
                    if (array_key_exists($i, $valuesToSplit)) {
                        foreach (explode($valuesToSplit[$i], $row[$i]) AS $item) {
                            $temp[] = $item;
                        }
                    } else {
                        $temp[] = $row[$i];
                    }
                }
                $row = $temp;
            }
            $csv[] = array_combine($headerData, $row);
        }
        return $csv;
    }
}
