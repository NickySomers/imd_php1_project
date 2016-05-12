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

    if($count >= 0){
         while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $item = array();
                $item[] = $row['picturePath'];

                

                //Getting hashtags from description
            
                $strlen = strlen($row['pdescription']);
                $description = "";
                $tag = false;
                for( $i = 0; $i <= $strlen; $i++ ) {
                    $char = substr( $row['pdescription'], $i, 1 );

                    if($char == "#"){
                        $description .= '<a href="">';
                        $description .= $char;
                        $tag = true;
                    }else{
                        if($tag == true){
                            if($char == " "){
                                $description .= '</a>';
                                $tag = false;
                            }else{
                                $description .= $char;
                            }
                        }else{
                            $description .= $char;
                        }
                        

                    }
                }

                $item[] = $description;


                $item[] = $row['username'];
                

                $now = time(); // or your date as well
                 $your_date = strtotime($row['date']);
                 $datediff = $now - $your_date;
                 $amount = floor($datediff/(60*60*24));
                 if($amount == 0){
                    $item[] = "Today";
                 }else{
                    if($amount == 1){
                        $item[] = "Yesterday";
                     }else{
                        $item[] = $amount . " days ago";
                     }
                 } 

                $item[] = $row['pid'];

                $like = $conn->query("SELECT * FROM posts_likes WHERE postId = '".$row['pid']."' AND userId = '".$_SESSION['user']."'" );
                if($like->rowCount() == 0){
                    $item[] = false;
                }else{
                    $item[] = true;
                }

                $allLikes = $conn->query("SELECT * FROM posts_likes WHERE postId = '".$row['pid']."'" );
                $item[] = $allLikes->rowCount();
                 
               
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