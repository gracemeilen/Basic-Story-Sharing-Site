<?php
require 'database.php';

session_start();

// check the token passed with the form submission. 
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$comment_id = (int)$_POST['delete_comment_id'];
$username = (string)$_SESSION['user_id'];

 // query the database to delete the comment you have specified.
$stmt = $mysqli->prepare("delete from comments where comment_id=? AND commenter=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('is', $comment_id, $username);
 
$stmt->execute();
 
$stmt->close();

// takes you back to the page where all the stories are. 
header("Location: all_stories.php");
exit();

 
?>