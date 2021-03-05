
<?php

/**
 * Transforms CSV file into array
 * @return array of data
 */
function transform_csv() {
  $row = 1;
  // Open the csv file
  if (($handle = fopen( "orders.csv" , "r" )) !== FALSE) {
      //read first row (titles)
      $titles = read_row( $handle );

      //read the csv file
      while ( ( $data = read_row( $handle ) ) !== FALSE) {
        //assign keys
        $data = array_combine( $titles, $data );

        //work on the rows
        print_r( $data );
        echo "<br />\n";
      }

    fclose($handle);
  }
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

?>
