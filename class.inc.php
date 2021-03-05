
<?php

/**
 * Transforms CSV file into array
 * @return array of data
 */
function transform_csv() {

  // Open the csv file
  if (($handle = fopen( "orders.csv" , "r" )) !== FALSE) {
      //read first row (titles)
      $titles = read_row( $handle );

      //read the csv file
      while ( ( $data = read_row( $handle ) ) !== FALSE) {
        //assign keys
        $rows[] = array_combine( $titles, $data );
      }

    fclose($handle);
  }

  return $rows;
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
