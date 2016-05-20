<?php
session_start();
	$db =  new Db();
	$conn = $db->connect();


$unfollow = $conn->query("DELETE FROM users_followers WHERE userId = ".$_POST['userId']." AND followUserId = ".$_SESSION['user']);

?>