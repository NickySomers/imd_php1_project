<?php
        spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    });   
    session_start();

    $db =  new Db();
    $conn = $db->connect();


    $userN = $_SESSION['user'];
    $id = $_POST['index'];

    $data[] = 0;
    $data = array();

    $query = $conn->query("SELECT DISTINCT p . *, u . *, p.description pdescription, p.id pid, TIMEDIFF(NOW(), date) FROM users_followers uf, posts p, users u WHERE uf.followUserId = '$userN' AND uf.userId = p.userId AND uf.userId = u.id AND p.id < '$id' ORDER BY p.id DESC LIMIT 2");	

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
                        $tag = true;
                        $tagname = "";
                    }else{
                        if($tag == true){

                            if($char == " " || $char == ""){

                                $description .= '<a href="search.php?q='.$tagname.'">#'.$tagname.'</a>';
                                $tag = false;
                                $tagname = "";

                            }else{
                                $tagname .= $char;
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
                 
                if(!empty($row['location'])){
                    
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$row['location'].'&key=AIzaSyAh_xS_8wsg53h_8Zb6nPbgj1_j8AMb84s';
                    $json = file_get_contents($url);
                    $data = json_decode($json, TRUE);
                    $item[] = $data['results'][0]['address_components'][2]['long_name'] . ", " . $data['results'][0]['address_components'][5]['long_name'];                
                }

                $item[] = $row['filter'];
                $item['avatar'] = $row['profilePicture'];

               
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