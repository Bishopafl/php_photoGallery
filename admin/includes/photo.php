<?php


class Photo extends Db_object {

	protected static $db_table = "photos";
	protected static $db_table_fields = array('photo_id', 'title', 'description', 'filename', 'type', 'size');
	public $photo_id;
	public $title;
	public $description;
	public $filename;
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

		// check is file is empty, or not a file, or not an array
		if(empty($file) || !$file || !is_array($file)){

			//saves string into array created above
			$this->errors[] = "There was no file uploaded man...";
			return false;

		} elseif ($file['error'] !=0) {

			// if error, save error in error file array
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;

		} else {

			$this->filename = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type 	 = $file['type'];
			$this->size 	 = $file['size'];

		}

	} // end of set_file function

	public function save(){

		if($this->photo_id){

			$this->update();
			
		} else {

			if(!empty($this->errors)){

				return false;
			}

			if(empty($this->filename) || empty($this->tmp_path)){

				$this->errors[] = "the file was not available";
				return false;
			}

			$target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

			if(file_exists($target_path)){
				// if target path exists, return our custom string
				// curly bracets and double quotes show php information
				$this->errors[] = "The file {$this->filename} already exists";
				return false;
			}

			if(move_uploaded_file($this->tmp_path, $target_path)){

				if($this->create()){

					unset($this->tmp_path);
					return true;
				}

			} else {

				$this->errors[] = "your file directory might not have permissions homie...";
				return false;

			}




		}

			
	} // end of save function


}






?>