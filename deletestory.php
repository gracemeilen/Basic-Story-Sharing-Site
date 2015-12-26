<?php
require 'database.php';

session_start();
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$story_id = (int)$_POST['delete_story_id'];
echo $story;
$username = (string)$_SESSION['user_id'];
echo $username;

 
$stmt = $mysqli->prepare("delete from stories where story_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('i', $story_id);
 
$stmt->execute();
 
$stmt->close();

header("Location: storydisplay.php");
exit();

 
?>