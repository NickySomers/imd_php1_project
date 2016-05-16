<?php
		spl_autoload_register(function ($class) {
            include_once '../classes/' . $class . '.class.php';
        });   


	session_start();

	$db =  new Db();
	$conn = $db->connect();

	$user = new User();
	$profile = new User();
	$user->Id = $_SESSION['user'];
	$profile->Id = $_POST['userId'];
	$user->getDataFromDatabase();
	$profile->getDataFromDatabase();

	if($profile->Private){
		$conn->query("INSERT INTO users_notifications(userId, notification, sender) VALUES ('".$profile->Id."', '@".$user->Username." wants to follow you.','".$user->Id."')");
	}else{
		$conn->query("INSERT INTO users_followers(userId , followUserId) VALUES ( ".$profile->Id." , ".$user->Id." )");
	}





?>