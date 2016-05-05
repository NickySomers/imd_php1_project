<?php
      
    session_start();

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userN = $_SESSION['user'];
    $id = $_POST['index'];

    $data[] = 0;
    $data = array();

    $query = $conn->query("SELECT p . *, u . *, p.description pdescription, p.id pid, TIMEDIFF(NOW(), date) FROM users_followers uf, posts p, users u WHERE uf.followUserId = '$userN' AND uf.userId = p.userId AND uf.userId = u.id AND p.id < '$id' ORDER BY p.id DESC LIMIT 2");	

    $posts = array();
    $count = $query->rowCount();

    if($count > 0){
         while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $item = array();
                $item[] = $row['picturePath'];

                $item[] = $row['pdescription'];
                $item[] = $row['username'];
                $item[] = $row['date'];

                $posts[] = $item;
                $lastIndex = $row['pid'];
            }

            $data[0] = $lastIndex;
            $data[1] = $posts;

            echo json_encode($data);
    }else{
        $data[0] = "TEST";
        echo json_encode($data);
    }

   


            
?>