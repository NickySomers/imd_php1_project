<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$unfollow = $conn->query("DELETE FROM users_followers WHERE userId = ".$_POST['userId']." AND followUserId = ".$_SESSION['user']);

?>