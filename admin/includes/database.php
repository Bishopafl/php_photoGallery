<?php 

require_once("new_config.php");

class Database {

	public $connection;
	// function creates connection to database
	function __construct(){
		$this->open_db_connection();
	} // end of construct

	public function open_db_connection(){
	// Apply connection to object to property make it object oriented
	$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		// Gotta check if the query didn't go right...
		if($this->connection->connect_errno){
			die("Database connection failed badly" . $this->connection->connect_error);
		}
	} // end of open db connection

	public function query($sql){
		// makes query to database
		$result = $this->connection->query($sql);
		$this->confirm_query($result);
		return $result;
	} // end of query function

	private function confirm_query($result){
		// if result fails, show custom message and error 
		if(!$result){
			die("Query failed bro..." .$this->connection->error);
		}
	} // end of confirm query function

	public function escape_string($string){
		$escaped_string = $this->connection->real_escape_string($string);
		return $escaped_string;
	} // end of escape string function

	public function the_insert_id(){
		return mysqli_insert_id($this->connection);
	} // end of insert id function

} // end of database class

$database = new Database();


?>
