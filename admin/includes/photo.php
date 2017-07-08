<?php
class Photo extends Db_object {

	protected static $db_table = "photos";
	protected static $db_table_fields = array('id', 'title', 'caption','description', 'filename', 'alternate_text' , 'type', 'size');
	public $id;
	public $title;
	public $caption;
	public $description;
	public $filename;
	public $alternate_text;
	public $type;
	public $size;

	// path for images to move them to a temporary path
	public $tmp_path;
	// path images will go to.  this is the perminate path
	public $upload_directory = "images";
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
			$this->filename = basename($file['name']);
			$this->type 	 = $file['type'];
			$this->tmp_path = $file['tmp_name'];
			$this->error 	 = $file['error'];
			$this->size 	 = $file['size'];
		}
	} // end of set_file function

	public function picture_path(){
		return $this->upload_directory.DS.$this->filename;
	}

	public function save(){
		// if photo id is found call update function
		if($this->id){

			$this->update();
			
		} else {

			// if errors array is not empty return false
			if(!empty($this->errors)){
				return false;
			}

			// if filename and temp path are empty return false
			if(empty($this->filename) || empty($this->tmp_path)){
				//custom message saving to errors array
				$this->errors[] = "the file is not available";
				return false;
			}

			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

			// if target path exists, return our custom string
			if(file_exists($target_path)){
				
				// FYI:curly bracets and double quotes show php information
				$this->errors[] = "The file {$this->filename} already exists";
				return false;
			}

			// PHP function takes filename and destination to move file
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
		} // end of error checking else statement... 
	} // end of save function

	// delete file from database and deletes from server
	public function delete_photo(){

		if ($this->delete()) {

			$target_path = SITE_ROOT.DS.'admin'.DS.$this->picture_path();
			// return true or false if able to or not
			return unlink($target_path) ? true : false;
		} else {
			// if all else fails..
			return false;
		}
	} // end of delete_photo
} // end of photo class






?>