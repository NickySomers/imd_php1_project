<?php
      
    session_start();

	$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = $_SESSION['user'];
    $postId = $_POST['postId'];

 	$posts_strike = $conn->query("SELECT * FROM posts_strike WHERE postId = '".$postId."'");

    //SELECT -> posts_strike -> postId = $postId AND userId = $user
    // -> IF -> rowCount -> == 0 -> Reporten
    // -> ELSE -> Niet reporten -> Echo foutmelding

 	if($posts_strike->rowCount() >= 2)
    {
 		$conn->query("DELETE FROM posts_strike WHERE userId = '".$user."' AND postId = '".$postId."'");
        $conn->query("DELETE FROM posts WHERE id = '".$postId."'");
 	}
    else
    {
        $conn->query("INSERT INTO posts_strike (userId, postId) VALUES ('".$user."', '".$postId."')");
 	}
           
?>
