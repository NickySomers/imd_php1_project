<?php 

	session_start();
	$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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