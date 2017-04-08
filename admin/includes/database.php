<?php 

require_once("new_config.php");

class Database {

	public $connection;

	// function creates connection to database
	function __construct(){

		$this->open_db_connection();

	}

	// calls open connection automatically
	public function open_db_connection(){

	// Apply connection to object to property make it object oriented
	$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

		// Gotta check if the query didn't go right...
		if($this->connection->connect_errno){
			die("Database connection failed badly" . $this->connection->connect_error);
		}
	}

	public function query($sql){
		
		// makes query to database
		$result = $this->connection->query($sql);

		$this->confirm_query($result);

		return $result;
	}


	// function to check the query...checks query, duh
	private function confirm_query($result){

		if(!$result){

			die("Query failed bro..." .$this->connection->error);
		}

	}

	public function escape_string($string){

		$escaped_string = $this->connection->real_escape_string($string);
		return $escaped_string;
	}

	public function the_insert_id(){

		return $this->connection->insert_id;

	}






}

$database = new Database();


?>
