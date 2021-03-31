<?php


/**
 * CVS inport class
 */
class FunkyCSV
{

	private function read_line( $handler ) {

		$line = fgets( $handler );

		if( empty( $line ) )
		return FALSE;

		// Maak van de cvs veld Vestiging / verkoper twee lossen velden.
		$line = preg_replace( '~ \/ (?!.* \/ )~' , ',' , $line );

		$line = str_getcsv( $line );

		return $line;
	}

	public $csv = "orders.csv";

	public function __construct() {

		if (($handler = fopen($this->csv, "r")) !== FALSE) {

			while ( ( $data = $this->read_line( $handler ) ) !== FALSE) {

				if(is_array($data)){
					// kijk of de eerst data dit geval ID een nummer is zo ja ga verder.
					if(is_numeric($data['0'])){	
						$db = new FonkyDB();

						//kijk of id al in database zit
						$TableName =  'FonkyOrderData';
						$Fields = array('id');
						$id = $data['0'];
						$Values = "WHERE id = $id";

						$result = $db->fonky_query_select($TableName,$Fields,$Values);
						// gaat verder als id nog niet in databse zit
						if($result->num_rows === 0){ 
							echo "Not exist</br>";
							if (count($data) === 6) {

								// maak van datum veld uit csv goede waarde die in mysql ingeladen kan worden.
								$date = DateTime::createFromFormat('d/m/Y H:i', $data['2']);
							
								$TableName =  'FonkyOrderData';
								$Fields = array("id,koper,datum,product,vestiging,verkoper");
								$Values = array( "$data[0]", 
									"\"".$data[1]."\"", 
									"\"". $date->format("Y-m-d H:i:s") ."\"", 
									"\"$data[3]\"", 
									"\"$data[4]\"", 
									"\"$data[5]\"" 
								);
								$db = new FonkyDB();
								$db->fonky_query_insert($TableName,$Fields,$Values);	
							}
						}
					}
				}
			}
		}
	}
}