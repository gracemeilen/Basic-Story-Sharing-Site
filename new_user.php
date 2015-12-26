<?php
require 'database.php';
 
$username = (string)$_POST['new_username'];
$password = (string) crypt($_POST['new_password']);

 
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
    echo "Failure";
	exit;
}
 
$stmt->bind_param('ss', $username, $password);
 
$stmt->execute();
 
$stmt->close();
header("Location: sign_in.html");
exit();
 
?>
