
<?php

$db = new FonkyDB();
$TableName =  'FonkyOrderData';
$Fields = array('verkoper');
$Values = "";

$result = $db->fonky_query_select_distinct($TableName,$Fields,$Values);

?>



<div class="container">

	<div class="mederwekers">

		<?php while ($row = $result->fetch_assoc()) { ?>

			<?php $naam = $row['verkoper'];?>

			<div class="mederwerker">

				<div class="Naam">

					<h3> <?php echo $naam;?> </h3>

				</div>


				<div class="verkooplijst">

					<?php

						$db = new FonkyDB();
						$TableName =  'FonkyOrderData';
						$Fields = array('*');
						$Values = "WHERE verkoper = '$naam'";

						$result_medewerker = $db->fonky_query_select($TableName,$Fields,$Values);

					?> 
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

								<?php while ($row = $result_medewerker->fetch_assoc()) { ?>

									<?php
									    echo "<tr>";

									    	echo "<td>$row[id]</td>";
									    	echo "<td>$row[koper]</td>";
									    	echo "<td>$row[datum]</td>";
									    	echo "<td>$row[product]</td>";
									    	echo "<td>$row[vestiging]</td>";
									    	echo "<td>$row[verkoper]</td>";

									    echo "</tr>";
									?>

								<?php } ?>

							</tbody>


						</table>
					</div>

				</div>


			</div>

		<?php } ?>

	</div>

</div>
