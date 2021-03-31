<?php

/**
 * CVS inport class
 */
class FonkyDB 
{
	private $hostname = 'localhost';
	private $username = 'fonky_db';
	private $password = 'UInzmQrq';
	private $database = 'fonky_db';

	private $connect;

	public function __construct()
	{
	   $this->connect = new mysqli($this->hostname, $this->username, $this->password, $this->database);

	   if ($this->connect->connect_error) {
	   		$this->error('Failed to connect to MySQL - ' . $this->connect->connect_error);
	   }

	   $query = "CREATE TABLE IF NOT EXISTS FonkyOrderData(
	     id INT,
	     koper VARCHAR(50),
	     datum DateTime,
	     product VARCHAR(10),
	     vestiging VARCHAR(20),
	     verkoper VARCHAR(50)
	   )";
	   $result = $this->connect->query( $query );

	}

	public function fonky_query_insert($TableName,$Fields,$Values)
	{	
		$QPreview = "INSERT INTO $TableName (". implode( ", ", $Fields ) .") VALUES (". implode( ", ", $Values ).")";

		if(!$sql = $this->connect->query($QPreview)){
			print_r("Er is iets fout gegaan </br>");
			print_r($QPreview);
		}
	}
	public function fonky_query_select($TableName,$Fields,$Values)
	{	
		$QPreview = "SELECT ". implode( ", ", $Fields ) ." FROM $TableName $Values";
		if($sql = $this->connect->query($QPreview)){
			return $sql;
		}else{
			print_r("Er is iets fout gegaan </br>");
			print_r($QPreview);
			return "";		
		}
	}

	public function fonky_query_select_distinct($TableName,$Fields,$Values)
	{	
		$QPreview = "SELECT DISTINCT ". implode( ", ", $Fields ) ." FROM $TableName $Values";
		if($sql = $this->connect->query($QPreview)){
			return $sql;
		}else{
			print_r("Er is iets fout gegaan </br>");
			print_r($QPreview);
			return "";		
		}
	}

	function __deconstruct() {
	   $this->conn->close();
	 }

}


?>