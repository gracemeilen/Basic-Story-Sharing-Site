<?php
require 'database.php';

session_start();

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}
$change_to = "no_longer_user";
$username = (string)$_SESSION['user_id'];

//
// changes the user associated with all the current user's story to a no_longer_user
//
$stmt = $mysqli->prepare("update stories set user =? where user=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ss', $change_to, $username);
 
$stmt->execute();
 
$stmt->close();


//
// changes the user associated with all the current user's comments to a no_longer_user
//
$stmt = $mysqli->prepare("update comments set commenter =? where commenter=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ss', $change_to, $username);
 
$stmt->execute();
 
$stmt->close();
 
 
 
//
// deletes the current user from the users table
//
$stmt = $mysqli->prepare("delete from users where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('s', $username);
 
$stmt->execute();
 
$stmt->close();

header("Location:sign_in.html");
exit();

 
?>