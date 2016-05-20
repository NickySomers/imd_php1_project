<?php
        spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   
    session_start();

    $db =  new Db();
    $conn = $db->connect();


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
