<?php

// Class that controls user information
class User extends Db_object {

	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $user_image;
	public $upload_directory = "images";
	public $image_placeholder = "http://placehold.it/400x400&text=image";

	// path for images to move them to a temporary path
	public $tmp_path;

	

	public function save_user_and_image(){
		// if photo id is found call update function

			// if errors array is not empty return false
			if(!empty($this->errors)){
				return false;
			}

			// if user_image and temp path are empty return false
			if(empty($this->user_image) || empty($this->tmp_path)){
				//custom message saving to errors array
				$this->errors[] = "the file is not available";
				return false;
			}

			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

			// if target path exists, return our custom string
			if(file_exists($target_path)){
				
				// FYI:curly bracets and double quotes show php information
				$this->errors[] = "The file {$this->user_image} already exists";
				return false;
			}

			// PHP function takes user_image and destination to move file
			if(move_uploaded_file($this->tmp_path, $target_path)){
				//if it created function works...
				if($this->create()){
					// unset the temporary path
					unset($this->tmp_path);
					return true;
				}
			} else {
				// if file didn't upload, save custom string to errors array
				$this->errors[] = "your file directory might not have permissions homie...";
				return false;

			}
	} // end of save function


	public function image_path_and_placeholder (){
		return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;


	}


	public static function verify_user($username, $password){
	global $database;

	//sanatizes username and password..
	$username = $database->escape_string($username);
	$password = $database->escape_string($password);

	$sql = "SELECT * FROM ". static::$db_table." WHERE ";
	$sql .= "username = '{$username}' ";
	$sql .= "AND password = '{$password}' ";
	$sql .= "LIMIT 1";

	$the_result_array = static::find_by_query($sql);

	return !empty($the_result_array) ? array_shift($the_result_array) : false;
	} // end of verify_user
} // end of user class
?>