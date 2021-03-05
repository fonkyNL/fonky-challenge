<!DOCTYPE html>

<html>
<head>
  <title>Fonky Sales Raport</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
  <script src="utils.js"></script>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php

// Include required classes and functionalities
require("database.inc.php");
require("csv.inc.php");
require("report.inc.php");

// Run the CSV file initiation
$data = new CSVs( "orders.csv" );


// Get data based on user request
$report = new FonkyReport( ( ( isset( $_REQUEST['report'] ) ) ? $_REQUEST['report'] : null ) );

?>

<div style="width:75%; margin: auto;">
	<canvas id="canvas"></canvas>
</div>

<div style="margin: auto; text-align: center;">
  <p><b>Rapoorten</b></p>
  <a class="button" href="?report=overzicht">Overzicht</a> &nbsp;
  <a class="button" href="?report=totaal_datum">Totaal Sales / Datum</a> &nbsp;
</div>

</body>
</html>
