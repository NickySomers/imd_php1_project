<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$unfollow = $conn->query("DELETE FROM users_followers WHERE userId = 20  AND followUserId = 14  ");
//".$_POST['userId']."
//".$_SESSION['user']."

?>