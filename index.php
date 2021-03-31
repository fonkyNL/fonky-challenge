<?php
	
	require('classes/class-fonky-db.php');
	require('classes/class-fonky-csv.php');
	$page = "";

	if($_GET['pageid']){
		$page = $_GET['pageid'];
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>

	<div class="container header">

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">Navbar</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarNav">

			    <ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="/">Home</a></li>
					<li class="nav-item"><a class="nav-link" href="/?pageid=totaal">Totaal</a></li>
					<li class="nav-item"><a class="nav-link" href="/?pageid=medewerkers">Medewerkers</a></li>
			    </ul>		
		    </div>
		  </div>
		</nav>
	</div>

	<?php if($page != ''){
		include("$page-page.php");
	}else{
		include("page.php");
	}?>

</body>
</html>