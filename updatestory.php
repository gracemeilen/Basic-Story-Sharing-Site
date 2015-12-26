<?php
require 'database.php';

session_start();
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$story_id = (int)$_POST['update_story_id'];
$story = (string)$_POST['update_story'];
$username = (string)$_SESSION['user_id'];

//
// query the  database to update the specified story
//

$stmt = $mysqli->prepare("update stories set story =? where story_id=? AND user=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sis', $story, $story_id, $username);
 
$stmt->execute();
 
$stmt->close();

//
// takes user back to the page that displays all the stories associated with your name.
//
header("Location: storydisplay.php");
exit();

 
?>