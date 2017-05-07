<?php 

class User {

	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;

	// selects all users from database
	public static function find_all_users(){
	
	return self::find_this_query("SELECT * FROM users");

	}

	// finds users by id 
	public function find_user_by_id($user_id){
	global $database;

		$the_result_array = self::find_this_query("SELECT * FROM users WHERE id = $user_id LIMIT 1");
		
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

	$sql = "SELECT * FROM users WHERE ";
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


	public function create(){
	global $database;

	$sql = "INSERT INTO users (username, password, first_name, last_name)";
	$sql .= "VALUES ('";
	$sql .= $database->escape_string($this->username) . "', '";
	$sql .= $database->escape_string($this->password) . "', '";
	$sql .= $database->escape_string($this->first_name) . "', '";
	$sql .= $database->escape_string($this->last_name) . "')";

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

		$sql = "UPDATE users SET ";
		$sql .= "username= '" . $database->escape_string($this->username)			. "', ";
		$sql .= "password= '" . $database->escape_string($this->password)			. "', ";
		$sql .= "first_name= '" . $database->escape_string($this->first_name)	. "', ";
		$sql .= "last_name= '" . $database->escape_string($this->last_name)		. "' ";
		$sql .= " WHERE id= " . $database->escape_string($this->id);
		
		$database->query($sql);

		// returns true or false depending on the outcome of the query, ternary style! swag...
		return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} // end of update method





} // end of user class







?>
