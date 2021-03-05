
<?php

/**
 * A Class to work with the CSV file
 */
class CSVs {

public $csvfile = "orders.csv";

/**
 * Transforms CSV file and insert data into database
 * @return array of data
 */
function __construct( $csvfile ) {
  // Get the database
  $db = new FonkyDB();

  // Test to see if the data is not already inserted
  $result = $db->select( "fonky_sales_data_status", array( "status") );
  if( $result[0] < 1 ) {

    // Open the csv file
    $this->csvfile = $csvfile;
    if (($handle = fopen( $this->csvfile , "r" )) !== FALSE) {
      //read first row (titles)
      $titles = $this->read_row( $handle );

      //read the csv file
      while ( ( $data = $this->read_row( $handle ) ) !== FALSE) {
        //assign keys
        // This is not needed any more. Just keeping for in case
        $row[] = array_combine( $titles, $data );

        //formating date
        $date = DateTime::createFromFormat('d/m/Y H:i', $data[2]);

        $db->insert( "fonky_sales_data", array( 'id', 'koper', 'datum', 'product', 'vestiging', 'verkoper' ),
                                         array( "$data[0]", "\"$data[1]\"", "\"". $date->format("Y-m-d H:i:s") ."\"", "\"$data[3]\"", "\"$data[4]\"", "\"$data[5]\"" ) );

      }

      fclose($handle);

      //set the status so the program insert data only once
      $db->insert( "fonky_sales_data_status", array( "status", "datum" ), array( "1", '\''. date("Y-m-d H:i:s") .'\'' ) );
    }

  }

  //return $rows;
}

/**
 * Read the data from each line in standard format
 * @param pointer to file (fopen)
 * @return array of fixed sales data
 */
function read_row( $handle ) {

  $line = fgets( $handle );

  if( empty( $line ) )
    return FALSE;

  // fix the last column to replace / with ,
  $line = preg_replace( '~ \/ (?!.* \/ )~' , ',' , $line );

  $line = str_getcsv( $line );

  return $line;
}

}
?>
