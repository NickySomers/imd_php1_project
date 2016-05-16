<?php

	spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   

	session_start();

	$id = $_POST['id'];

	$db =  new Db();
	$conn = $db->connect();

	$query = $conn->query("SELECT userId, sender FROM users_notifications WHERE id = ". $id);

	$notification_user = $query->fetch(PDO::FETCH_NUM);

	$conn->query("DELETE FROM users_notifications WHERE userId = ".$notification_user[0]." AND sender = ".$notification_user[1]);

?>