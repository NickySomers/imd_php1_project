<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $data = $conn->query("INSERT INTO users_followers(userId , followUserId ) VALUES (".$_GET['id']." , ".$_SESSION['user']." )");
// $data = $conn->query("INSERT INTO users_followers(userId , followUserId) VALUES ( ".$_GET['id']." , ".$_SESSION['user'].")");
$data = $conn->query("INSERT INTO users_followers(userId , followUserId) VALUES ( ".$_POST['userId']." , ".$_SESSION['user']." )");

?>