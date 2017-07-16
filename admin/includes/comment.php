<?php

// Class that controls user information
class Comment extends Db_object {

	protected static $db_table = "comments";
	protected static $db_table_fields = array('id', 'photo_id', 'author', 'body');
	public $id;
	public $photo_id;
	public $author;
	public $body;
	public $timestamp;

// takes parameters and instantiate into variables to object properties
	public static function create_comment($photo_id, $author="John Doe", $body="", $timestamp){
		if (!empty($photo_id) && !empty($author) && !empty($body)) {
			$comment = new Comment();

			

			

			$comment->photo_id = (int)$photo_id;
			$comment->author = $author;
			$comment->body = $body;
			$comment->timestamp = $timestamp;

			return $comment;
		} else {
			return false;
		}
	} // end of create_comment function

	public static function find_the_comment($photo_id=0){
		global $database;

		$sql = "SELECT * FROM " . self::$db_table;
		$sql.= " WHERE photo_id = " . $photo_id;
		$sql.= "ORDER BY photo_id ASC";

		return self::find_by_query($sql);
	} // end of find_the_comment


} // end of comment class
?>