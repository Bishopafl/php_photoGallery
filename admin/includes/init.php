<?php 

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles' . DS . 'htdocs' . DS . 'photo_gallery');

defined('SITE_ROOT') ? define('INCLUDES_PATH', SITE_ROOT . DS . 'admin'.DS.'includes') : null;

//require once is more secure
require_once(INCLUDES_PATH.DS.'functions.php');
require_once(INCLUDES_PATH.DS.'new_config.php');
require_once(INCLUDES_PATH.DS.'database.php');
require_once(INCLUDES_PATH.DS.'db_object.php');
require_once(INCLUDES_PATH.DS.'user.php');
require_once(INCLUDES_PATH.DS.'photo.php');
require_once(INCLUDES_PATH.DS.'session.php');

// paths and constants later will go here...

?>