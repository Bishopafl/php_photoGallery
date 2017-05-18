<?php 
// check if user is logged in or not logged in
// if user logged in, redirect to admin
// if not, kick to index
class Session {

	private $signed_in = false;
	public  $user_id;
	public  $message;


	function __construct(){
		// starts session
		session_start();
		$this->check_the_login();
		$this->check_message();

	}

	// basically outputs a message to the screen
	public function message($msg=""){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		} else {
			return $this->message;
		}
	}

	// checks if the message has a value in it
	public function check_message(){

		if(isset($_SESSION['message'])){

			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {

			$this->message = "";
		}


	}


	// Getter function returns true or false if user is signed in...
	public function is_signed_in(){

		return $this->signed_in;

	} // end is_signed_in function

	// function logs in user if user is there based on session
	public function login($user){

		if($user){

			$this->user_id = $_SESSION['user_id'] = $user_id->id;
			$this->signed_in = true;
		}

	} // end login function

	// function logs user out of session, unsets the user id and sets signed in to false
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->signed_in = false;

	}// end logout function

	// checks if session id is set
	public function check_the_login(){

		// if user exists in session set user...
		if(isset($_SESSION['user_id'])){
			// set user_id to the session id
			$this->user_id = $_SESSION['user_id'];
			$this->signed_in = true;
		} else {
			// if not, unset user id and signed in is false
			unset($this->user_id);
			$this->signed_in = false;
		}


	} // end check_the_login function

} // end Session class

$session = new Session();








?>