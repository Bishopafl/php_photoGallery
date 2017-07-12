<?php 
// parent class that talks to the database
class Db_object {

		// custom errors
	public $errors = array();
	//errors for uploads 
	public $upload_errors_array = array(
		UPLOAD_ERR_OK				=> "There is no error",
		UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive",
		UPLOAD_ERR_FORM_SIZE		=> "The uploaded file exceeds the MAX_FILE_SIZE directive",
		UPLOAD_ERR_PARTIAL		=> "The uploaded file was only partially uploaded.",
		UPLOAD_ERR_NO_FILE		=> "No file was uploaded.",
		UPLOAD_ERR_NO_TMP_DIR	=> "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE	=> "Failed to write file to disk.",
		UPLOAD_ERR_EXTENSION		=> "A PHP extension stopped the file upload."

	);

	

	// This is passing $_FILES['uploaded_file'] as an argument
	public function set_file($file){

		if (!isset($file)) {
			//saves string into array created above
			$this->errors[] = "There was no file uploaded man...";
			return false;
		} elseif ($file['error'] !=0) {
			// if error, save error in error file array
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;
		} elseif (isset($file)) {
			$this->user_image = basename($file['name']);
			$this->type 	 = $file['type'];
			$this->tmp_path = $file['tmp_name'];
			$this->error 	 = $file['error'];
			$this->size 	 = $file['size'];
		}
	} // end of set_file function

	// selects all from database
	public static function find_all(){
		// due to  late static binding, I will be using the static:: call instead of self::
		return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
	} // end of find_all


	public static function find_by_id($id){
		global $database;
		$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = " . $database->escape_string($id) . " LIMIT 1");
		// example of ternary vs. if else statement 
		return !empty($the_result_array) ? array_shift($the_result_array) : false;
	} // end of find_by_id

	public function find_by_query($sql){
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
		foreach (static::$db_table_fields as $db_field) {
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
			// clean entered properties 
			$properties  = $this->clean_properties();
			// define property pairs array
			$properties_pairs = array();
			// loop through properties to set key and value and store to properties pairs array
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

	// delete the database of information
	public function delete(){
		global $database;

		$sql = "DELETE FROM " .static::$db_table. " ";
		$sql .= "WHERE id= " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";

		$database->query($sql);
		// returns true or false depending on the outcome of the query, ternary style! swag...
		return (mysqli_affected_rows($database->connection) == 1) ? true : false; 

	} // end of delete method 

	// cleaning values and assigning them to arrays
	protected function clean_properties(){
		global $database;
		$clean_properties = array();
		// loop through properties to pull out keys and values
		foreach ($this->properties() as $key => $value) {
			$clean_properties[$key] = $database->escape_string($value);
		}
		return $clean_properties;
	} // end of clean_properties
} // end of Db_object



?>