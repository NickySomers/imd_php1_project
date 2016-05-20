<?php
	spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   
	session_start();

    $comment = new Comment();
    $comment->Text = $_POST['text'];
    $comment->User = $_SESSION['user'];
    $comment->Post = $_POST['postId'];

    $comment->add();

    $user = new User();
    $user->Id = $comment->User;
    $user->getDataFromDatabase();

    $data = array();

    $data[] = $user->Username;
    $data[] = htmlspecialchars($comment->Text);

    echo json_encode($data);
    
?>