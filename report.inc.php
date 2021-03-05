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
  $colors = array( "window.chartColors.red", "window.chartColors.orange", "window.chartColors.yellow", "window.chartColors.green", "window.chartColors.blue", "window.chartColors.purple", "window.chartColors.grey" );

  // Navigate based on request
  switch ( $request ) {
    case 'totaal_datum':

      echo "<h1>Fonky Sales Totaal Verkoop</h1>";
      echo "<h2>op basis van datum</h2>";

      echo "<script>";

      $result = $db->select( "fonky_sales_data", array( "count(*) AS tellen", "DATE(datum) as datum" ), "GROUP BY CAST(datum as DATE)" );

      echo "var config = { \n";
      echo "  type: 'line',\n";
      echo "  data: {\n";
      echo "    labels: " . json_encode( array_values ( array_unique( array_column( $result[1], "datum" ) ) ) ) . ",\n" ;
      echo "    datasets: [{\n";
      echo "      label: 'Totaal Verkoop per Dag',\n";
      echo "      backgroundColor: window.chartColors.red, \n";
      echo "      borderColor: window.chartColors.red,\n";
      echo "      data: ";
      echo json_encode( array_values ( array_column( $result[1], "tellen" ) ) ) . ",\n";
      echo "    fill: false,\n";
      echo "    }]\n";
      echo "  },\n";
      echo "
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Fonky Sales - Totaal Verkoop per Datum'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Datum'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Totaal Verkoop'
            }
          }]
        }
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('canvas').getContext('2d');
      window.myLine = new Chart(ctx, config);
    };";
      echo "</script>";

      break;

    case 'totaal_vestiging':

      echo "<h1>Fonky Sales Totaal Verkoop</h1>";
      echo "<h2>op basis van vestiging</h2>";

      echo "<script>";

      $result = $db->select( "fonky_sales_data", array( "count(*) AS tellen", "vestiging" ), "GROUP BY vestiging" );

      echo "var config = { \n";
      echo "  type: 'pie',\n";
      echo "  data: {\n";
      echo "    datasets: [{\n";
      echo "      data: ". json_encode( array_values ( array_column( $result[1], "tellen" ) ) ) . ",\n";
      echo "      backgroundColor: ". str_replace( "\"", "", json_encode( $colors ) ) .",\n";
      echo "      label: 'Dataset 1'\n";
      echo "    }],\n";
      echo "    labels: " . json_encode( array_values ( array_unique( array_column( $result[1], "vestiging" ) ) ) ) . "\n" ;
      echo "  },\n";
      echo "
      options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};";
      echo "</script>";

      break;

    // General report on number of sales based on city
    default:

      echo "<h1>Fonky Sales Verkooprapport</h1>";
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
        echo "      backgroundColor: ". $colors[ $i ] .", \n";
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
