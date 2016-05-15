<?php

  	spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   

	$db = new Db();
	$conn = $db->connect();

	$posts = $conn->query("SELECT * FROM posts WHERE description LIKE '%#".$_GET['q']."%'");

	while($row = $posts->fetch(PDO::FETCH_ASSOC)){

		echo $row['description'];

	}

?>