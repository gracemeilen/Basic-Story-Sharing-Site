<?php
require 'database.php';

session_start();
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$comment_id = (int)$_POST['update_comment_id'];
$comment = (string)$_POST['update_comment'];
$username = (string)$_SESSION['user_id'];

 
$stmt = $mysqli->prepare("update comments set comment =? where comment_id=? AND commenter=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sis', $comment, $comment_id, $username);
 
$stmt->execute();
 
$stmt->close();

header("Location: all_stories.php");
exit();

 
?>