<?php 

// check if user is logged in or not logged in
// if user logged in, redirect to admin
// if not, kick to index
class Session {

	private $signed_in = false;
	public $user_id;


	function __construct(){
		// starts session
		session_start();
		$this->check_the_login();

	}

	// Getter function returns true or false if user is signed in...
	public function is_signed_in(){

		return $this->signed_in;

	}

	// function logs in user if user is there based on session
	public function login($user){

		if($user){

			$this->user_id = $_SESSION['user_id'] = $user_id->id;
			$this->signed_in = true;
		}

	}

	// function logs user out of session, unsets the user id and sets signed in to false
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->signed_in = false;

	}

	// checks if session id is set
	private function check_the_login(){

		// if user exists in session set user...
		if(isset($_SESSION['user_id'])){

			$this->user_id = $_SESSION['user_id'];
			$this->signed_in = true;
		} else {
			// if not, unset user id and signed in is false
			unset($this->user_id);
			$this->signed_in = false;
		}


	}

}

$session = new Session();








?>