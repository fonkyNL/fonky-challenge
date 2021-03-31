<?php
if(isset($_REQUEST['csv-in']))
{
    new FunkyCSV();

}elseif(isset($_REQUEST['koper'])){

	$result = '';
	$db = new FonkyDB();
	$TableName =  'FonkyOrderData';
	$Fields = array('*');
	$postvalue = $_POST['kopersvalue'];
	$Values = "WHERE koper LIKE '%$postvalue%'";

	$result = $db->fonky_query_select($TableName,$Fields,$Values);

}elseif(isset($_REQUEST['product'])){

	$result = '';
	$db = new FonkyDB();
	$TableName =  'FonkyOrderData';
	$Fields = array('*');
	$postvalue = $_POST['productvalue'];
	$Values = "WHERE product LIKE '%$postvalue%'";

	$result = $db->fonky_query_select($TableName,$Fields,$Values);

}elseif(isset($_REQUEST['datumold'])){

	$result = '';
	$db = new FonkyDB();
	$TableName =  'FonkyOrderData';
	$Fields = array('*');
	$Values = "ORDER BY datum ASC;";

	$result = $db->fonky_query_select($TableName,$Fields,$Values);

}elseif(isset($_REQUEST['datumnew'])){

	$result = '';
	$db = new FonkyDB();
	$TableName =  'FonkyOrderData';
	$Fields = array('*');
	$Values = "ORDER BY datum DESC;";

	$result = $db->fonky_query_select($TableName,$Fields,$Values);

}else{

	$result = '';
	$db = new FonkyDB();
	$TableName =  'FonkyOrderData';
	$Fields = array('*');
	$Values = "";

	$result = $db->fonky_query_select($TableName,$Fields,$Values);
}

?>



<div class="container">
<div class="submits">
	<form action="" method="post">
		<input class="btn btn-primary" type="submit" name="csv-in" value="CSV inport" />
	</form>
	<div class="Koper">
		<h3> Zoek op koper: </h3>
		<form action="" method="post">
			<div class="form-check form-check-inline">
				<input class="form-control-sm" type="text" name="kopersvalue">
				<input class="btn btn-primary" type="submit" name="koper" value="Zoek" />
			</div>
		</form>
	</div>
	<div class="proudct">
		<h3> Zoek op product: </h3>
		<form action="" method="post">
			<div class="form-check form-check-inline">
				<input class="form-control-sm"  type="text" name="productvalue">
				<input class="btn btn-primary" type="submit" name="product" value="Zoek" />
			</div>
		</form>
	</div>
	<div class="proudct">
		<h3> Order datum: </h3>
		<form action="" method="post">
			<div class="form-check form-check-inline">
				<input class="btn btn-primary"type="submit" name="datumold" value="Oud naar nieuw" />
				<input class="btn btn-primary" type="submit" name="datumnew" value="Nieuw naar oud" />
			</div>
		</form>
	</div>

</div>
<div class="info-table">

	<?php if($result != ''){ ?>

		<?php if($result->num_rows != 0){ ?>
			<div class="table-responsive">
				<table class="table table-striped"> 
					<thead>
						<tr>
							<th>ID</th>
							<th>koper</th>
							<th>Datum</th>
							<th>Product</th>
							<th>Vestiging</th>
							<th>Verkoper</th>
						</tr>
					</thead>

					<tbody>
						<?php

							while ($row = $result->fetch_assoc()) {

							    echo "<tr>";

							    	echo "<td>$row[id]</td>";
							    	echo "<td>$row[koper]</td>";
							    	echo "<td>$row[datum]</td>";
							    	echo "<td>$row[product]</td>";
							    	echo "<td>$row[vestiging]</td>";
							    	echo "<td>$row[verkoper]</td>";

							    echo "</tr>";
							}

						?>

					</tbody>


				</table>
			</div>

		<?php }else{ ?>

			<p>Er is helaas niks gevonden op u zoek term. </p>

		<?php  } ?>

	<?php } ?>

</div>

</div>