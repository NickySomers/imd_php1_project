<?php
      
    session_start();

	$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = $_SESSION['user'];
    $postId = $_POST['postId'];

 	$posts_strike = $conn->query("SELECT * FROM posts_strike WHERE postId = '".$postId."'");
    $posts_limit = $conn->query("SELECT * FROM posts_strike WHERE postId = '".$postId."' AND userId = '".$user."'");

    if($posts_limit->rowCount() == 0)
    {        
        if($posts_strike->rowCount() >= 2)
        {
            $conn->query("DELETE FROM posts_strike WHERE userId = '".$user."' AND postId = '".$postId."'");
            $conn->query("DELETE FROM posts WHERE id = '".$postId."'");
        }
        else
        {
            $conn->query("INSERT INTO posts_strike (userId, postId) VALUES ('".$user."', '".$postId."')");
        }
    }
    else
    {
        echo true;
    }

 	
           
?>
