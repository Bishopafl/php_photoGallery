<?php 

class User {

	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;

	// selects all users from database
	public static function find_all(){
	
	return self::find_this_query("SELECT * FROM" . self::$db_table . " ");

	}

	// finds users by id 
	public function find_by_id($user_id){
	global $database;

		$the_result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id = $user_id LIMIT 1");
		
		// example of ternary vs. if else statement 
		return !empty($the_result_array) ? array_shift($the_result_array) : false;

	}

	public static function find_this_query($sql){
	global $database;

		$result_set = $database->query($sql);
		$the_object_array = array();

		// fetches table and brings back result set from columns in database
		while ($row = mysqli_fetch_array($result_set)) {
			
			// uses the instantion function to loops through and
			// assign values to the objects in array 
			$the_object_array[] = self::instantiation($row);

		}

	return $the_object_array;


	}

	public static function verify_user($username, $password){
	global $database;

	//sanatizes username and password..
	$username = $database->escape_string($username);
	$password = $database->escape_string($password);

	$sql = "SELECT * FROM ". self::$db_table." WHERE ";
	$sql .= "username = '{$username}' ";
	$sql .= "AND password = '{$password}' ";
	$sql .= "LIMIT 1";


	$the_result_array = self::find_this_query($sql);
	
	return !empty($the_result_array) ? array_shift($the_result_array) : false;



	}


	// getting record from table
	public static function instantiation($the_record){

		$the_object = new self;

	   // $the_object->id 			= $found_user['id'];
	   // $the_object->username 	= $found_user['username'];
	   // $the_object->password 	= $found_user['password'];
	   // $the_object->first_name = $found_user['first_name'];
	   // $the_object->last_name 	= $found_user['last_name'];

		// looping through record
	   foreach ($the_record as $the_attribute => $value) {
	   	
	   	// passing key of the array returns true or false
	   	if ($the_object->has_the_attribute($the_attribute)){

	   		// assigning object the value
	   		$the_object->$the_attribute = $value;

	   	}

	   }

	   return $the_object;

	}
 
	private function has_the_attribute($the_attribute){

		$object_properties = get_object_vars($this);

		return array_key_exists($the_attribute, $object_properties);

	}

	protected function properties(){

		$properties = array();

		// loops through the associative array and assigns keys and values
		foreach (self::$db_table_fields as $db_field) {
			if (property_exists($this, $db_field)) {
				
				$properties[$db_field] = $this->$db_field;
			}
		}

		return $properties;

	} // end of properties method

	// cleaning values and assigning them to arrays
	protected function clean_properties(){
		global $database;

		$clean_properties = array();

		// loop through properties to pull out keys and values
		foreach ($this->properties() as $key => $value) {
			
			$clean_properties[$key] = $database->escape_string($value);

		}

		return $clean_properties;

	}

	// function detects if user is there it will updates, if not there create the user
	public function save(){

		return isset($this->id) ? $this->update() : $this->create();

	}

	public function create(){
		global $database;
		$properties = $this->clean_properties();

	$sql = "INSERT INTO " .self::$db_table. "(" . implode(",", array_keys($properties)) . ")";
	$sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

	//do some testing in an if statement
	//returns true or false
	if ($database->query($sql)) {
		
		$this->id = $database->the_insert_id();

		return true;

	} else{

		return false;
	} 

	} // end of create method

	// update the database of user information
	public function update(){
		global $database;

			$properties  = $this->clean_properties();

			$properties_pairs = array();

			foreach ($properties as $key => $value) {
				
				$properties_pairs[] = "{$key} ='{$value}'";

			}

			$sql = "UPDATE " .self::$db_table. " SET ";
			$sql .= implode(", ", $properties_pairs);
			$sql .= " WHERE id= " . $database->escape_string($this->id);
			
			$database->query($sql);

			// returns true or false depending on the outcome of the query, ternary style! swag...
			return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} // end of update method

	// update the database of user information
	public function delete(){
		global $database;

		$sql = "DELETE FROM " .self::$db_table. " ";
		$sql .= "WHERE id= " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";

		$database->query($sql);

		// returns true or false depending on the outcome of the query, ternary style! swag...
		return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} // end of update method




} // end of user class







?>
