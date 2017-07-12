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