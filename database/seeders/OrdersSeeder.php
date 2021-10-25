<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "orders.csv";
        $table    = "orders";


        $this->importOrdersFromCsv($filename, $table);

        
        //DB::insert('INSERT INTO orders (orderId, koper, orderdatum, productId, vestigingEnVerkoper) VALUES (?,?,?,?,?)', $record);
        //
    }

    /**
     * Import orders from CSV file into database
     * 
     * @return void
     */
    private function importOrdersFromCsv($filename, $table) {

        if (!file_exists($filename)) return;
    
        $maxLineLength  = 10000;    // Maximale lengte in bytes van 1 regel (= 1 record)
        $fieldSeparator = ",";
        $fieldEnclosure = '"';
        $escape         = "\\";
        $fileAccessMode = "r";
        $skipHeader     = true;
    

        if (($handle = fopen($filename, $fileAccessMode)) !== false) {
            while (($rawRecord = fgetcsv($handle, $maxLineLength, $fieldSeparator, $fieldEnclosure, $escape)) !== false) { 
                if ($skipHeader) {
                    $skipHeader = false;
                    continue;
                }
                $record = $this->fixRecord($rawRecord);

                DB::insert('INSERT INTO orders (orderId, koper, orderdatum, productId, vestiging, verkoper) VALUES (?,?,?,?,?,?)', $record);
            }
        }
    }

    /**
     * Fix records before saving to database
     * 
     * @return array
     */
    private function fixRecord($rawRecord) {
        $fixedRecord = $rawRecord;

        // Fix orderdatum:
        $fixedRecord[2] = $this->convertDateEuropeanToMysql($rawRecord[2]);
        
        // Fix vestiging en verkoper:
        $vestigingEnVerkoper = explode("/", $rawRecord[4]);
        $fixedRecord[4] = trim($vestigingEnVerkoper[0]);
        $fixedRecord[5] = trim($vestigingEnVerkoper[1]);

        return $fixedRecord;
    }

    /**
     * Convert date from European date/timestamp to MySQL date/timestamp.
     * Convert precisely from "dd/mm/yyyy hh:mm" to "yyyy-mm-dd hh:mm:ss"
     * 
     * @return string
     */
    private function convertDateEuropeanToMysql($europeanDateTime) {
        // europeanDateTime format: dd/mm/yyyy hh:mm
        // mysqlDateTime    format: yyyy-mm-dd hh:mm:ss

        $mysqlDateTime = "";

        $europeanDateTimePattern = '/([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}:[0-9]{2})/';
        preg_match($europeanDateTimePattern, $europeanDateTime, $dateParts);

        if (!empty($dateParts)) {
            $day   = $dateParts[1];
            $month = $dateParts[2];
            $year  = $dateParts[3];
            $time  = $dateParts[4];
            $mysqlDateTime = "$year-$month-$day $time:00";
        }
        return $mysqlDateTime;
    }

}
