<?php
      
    session_start();

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userN = $_SESSION['user'];
    $id = $_POST['index'];

    $data = array();

    $posts = $conn->query("SELECT DISTINCT p . *, u . *, p.description pdescription, p.id pid FROM users_followers uf, posts p, users u WHERE uf.followUserId = '$userN' AND uf.userId = p.userId AND uf.userId = u.id AND p.id < '$id' ORDER BY p.date DESC LIMIT 2");	

    $data[] = 0;

    while($row = $posts->fetch(PDO::FETCH_ASSOC)){
    	$item = array();
    	$item[] = $row['picturePath'];
    	$item[] = $row['pdescription'];
    	$data[] = $item;
    	$lastIndex = $row['pid'];
    }

    $data[0] = $lastIndex;

    echo json_encode($data);

            
?>