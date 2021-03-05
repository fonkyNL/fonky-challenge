<?php

/**
 * Class for functionalities related to reporting from the Database
 */
class FonkyReport {

/**
 * Navigte through different reports
 */
function __construct( $request = null ) {

  $db = new FonkyDB;
  $colors = array( "red", "orange", "yellow", "green", "blue", "purple", "grey" );

  // Navigate based on request
  switch ( $request ) {
    case 'value':
      // code...
      break;

    // General report on number of sales based on city
    default:

      echo "<h1>Verkooprapport</h1>";
      echo "<h2>op basis van vestiging en datum</h2>";

      echo "<script>";

      $result = $db->select( "fonky_sales_data", array( "count(*) AS tellen", "DATE(datum) as datum", "vestiging" ), "GROUP BY CAST(datum as DATE), vestiging" );

      // Get cities
      $cities = array_values ( array_unique( array_column( $result[1], "vestiging" ) ) );

      // Get axil data (dates)
      $axil = array_values ( array_unique( array_column( $result[1], "datum" ) ) );
      echo "var barChartData = { \n";
      echo "  labels: " . json_encode( $axil ) . ",\n" ;
      echo "  datasets: [";

      $i = 0;
      // loop through list of cities
      foreach ($cities as $city) {
        echo "{ \n";
        echo "      label: '$city', \n";
        echo "      backgroundColor: window.chartColors.". $colors[ $i ] .", \n";
        echo "      data: [";

        $dumpdata = array();
        //loop through dates to assign corsepondence value or zero if no data for the city for the date
        foreach ($axil as $fdate) {
          //Get data from db
          $date_city_result = $db->select("fonky_sales_data", array( "id" ), "WHERE vestiging='$city' AND DATE(datum)='$fdate'" );
          $dumpdata[] = $date_city_result[0] ;
        }
        echo implode( ",", $dumpdata ) ."] \n";
        echo "    },";
        ++$i;
      }

      echo "] \n";
      echo "  };";

      echo "
      window.onload = function() {
  			var ctx = document.getElementById('canvas').getContext('2d');
  			window.myBar = new Chart(ctx, {
  				type: 'bar',
  				data: barChartData,
  				options: {
  					title: {
  						display: true,
  						text: 'Fonky Sales - Initial Repport'
  					},
  					tooltips: {
  						mode: 'index',
  						intersect: false
  					},
  					responsive: true,
  					scales: {
  						xAxes: [{
  							stacked: true,
  						}],
  						yAxes: [{
  							stacked: true
  						}]
  					}
  				}
  			});
  		};";

      echo "</script>";
      //print_r($result[1]);

      break;
  }

}

}

?>
