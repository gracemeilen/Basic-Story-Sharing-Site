<?php
require 'database.php';

session_start();
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$story = (string)$_POST['story'];
$username = (string)$_SESSION['user_id'];
$link = (string)$_POST['link'];

//
// query database to insert the specified story and link and associate it with the current user.
//
$stmt = $mysqli->prepare("insert into stories (story, user, link) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sss', $story, $username, $link);
 
$stmt->execute();
 
$stmt->close();

//
//takes you to the page that displays all the stories associated with current user
//
header("Location: storydisplay.php");
exit();

 
?>