<?php 
	spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   
	session_start();
		$db =  new Db();
	$conn = $db->connect();


    $user = $_SESSION['user'];
    $id = $_POST['id'];

 	$data = $conn->query("SELECT * FROM posts_likes WHERE postId = '".$id."' AND userId = '".$user."'" ); 

 	if($data->rowCount() == 0)
    {
 		$conn->query("INSERT INTO posts_likes (postId, userId) VALUES ('".$id."', '".$user."')" ); 
 		echo true;
 	}
    else
    {
 		$conn->query("DELETE FROM posts_likes WHERE postId = '".$id."' AND userId = '".$user."'" ); 
 		echo false;
 	}

?>