<?php 


class Db_object {

	protected static $db_table = "users";

	// selects all from database
	public static function find_all(){
		// due to  late static binding, I will be using the static:: call instead of self::
		return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
	} // end of find_all


	public function find_by_id($user_id){
		global $database;

		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $user_id LIMIT 1");
		
		// example of ternary vs. if else statement 
		return !empty($the_result_array) ? array_shift($the_result_array) : false;

	} // end of find_by_id

	public static function find_by_query($sql){
		global $database;

		$result_set = $database->query($sql);
		$the_object_array = array();

		// fetches table and brings back result set from columns in database
		while ($row = mysqli_fetch_array($result_set)) {
			
			// uses the instantion function to loops through and
			// assign values to the objects in array 
			$the_object_array[] = static::instantiation($row);
		}

		return $the_object_array;

	} // end of find_by_query




	// getting record from table
	public static function instantiation($the_record){

		$calling_class = get_called_class();

		$the_object = new $calling_class;

		// looping through record
	   foreach ($the_record as $the_attribute => $value) {
	   	
	   	// passing key of the array returns true or false
	   	if ($the_object->has_the_attribute($the_attribute)){

	   		// assigning object the value
	   		$the_object->$the_attribute = $value;

	   	}
	   }

	   return $the_object;

	} // end of instatiation

		private function has_the_attribute($the_attribute){

			$object_properties = get_object_vars($this);
			return array_key_exists($the_attribute, $object_properties);

	} // end of has_the_attribute

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

	// function detects if record is there it will updates, if not there create data
	public function save(){

		return isset($this->id) ? $this->update() : $this->create();

	} // end of save method

	public function create(){
		global $database;
		$properties = $this->clean_properties();

		$sql = "INSERT INTO " . static::$db_table. "(" . implode(",", array_keys($properties)) . ")";
		$sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

		//do some testing in an if statement
		//returns true or false
		if ($database->query($sql)) {
			$this->id = $database->the_insert_id();
			return true;
		}else{
			return false;
		} 
	} // end of create method

	// update the database of information
	public function update(){
		global $database;

			$properties  = $this->clean_properties();

			$properties_pairs = array();

			foreach ($properties as $key => $value) {
				
				$properties_pairs[] = "{$key} ='{$value}'";

			}

			$sql = "UPDATE " .static::$db_table. " SET ";
			$sql .= implode(", ", $properties_pairs);
			$sql .= " WHERE id= " . $database->escape_string($this->id);
			
			$database->query($sql);

			// returns true or false depending on the outcome of the query, ternary style! swag...
			return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} // end of update method

	// update the database of user information
	public function delete(){
		global $database;

		$sql = "DELETE FROM " .static::$db_table. " ";
		$sql .= "WHERE id= " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";

		$database->query($sql);

		// returns true or false depending on the outcome of the query, ternary style! swag...
		return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} /* end of update method */

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


}




?>