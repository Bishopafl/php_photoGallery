<?php 

// saftey net function to check files are in the includes even if they aren't in the init file
function classAutoLoader($class){
	// makes sure everything is lowercase
	$class = strtolower($class);
	// checks class in file
	$the_path = INCLUDES_PATH."/{$class}.php";
	if(is_file($the_path) && !class_exists($class)){
		include $the_path;
	} else {
		die("This file named {$class}.php was not found homie...");
	}
} // end of classAutoLoaderd

function redirect($location){
	//redirects to location
	header("Location: {$location}");
}

// autoloads registers because the autoload function might be deprecated..
spl_autoload_register('classAutoLoader');



?>