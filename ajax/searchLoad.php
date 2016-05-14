<?php
    $key = $_POST['input'];
    /*$user = $_SESSION['user'];*/
    $array = array();
    $tags = array();
    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $user = $conn->query("SELECT *, (SELECT COUNT(*) FROM users_followers WHERE userId = u.id) AS followers FROM users u WHERE username LIKE '%{$key}%' OR firstname LIKE '%{$key}%' OR lastname LIKE '%{$key}%' ORDER BY followers DESC LIMIT 10");
    $tag = $conn->query("SELECT * FROM posts_tags WHERE tag LIKE '%{$key}%' LIMIT 10");
    while($u = $user->fetch(PDO::FETCH_ASSOC))
    {
        $array[] = "<div class='container-block'><a href='profile.php?id=".$u['id']."'><div class='wrap-item'><div class='utext-left'><div class='utext-width'><div class='search-pic' style='background-image: url(".$u['profilePicture'].")'></div></div><div class='utext utext-width'>".$u['username']."</div></div><div class='utext utext-right'>".$u['firstname']." ".$u['lastname']."</div></div></a></div>";
    }
    while($t = $tag->fetch(PDO::FETCH_ASSOC))
    {
        $tags[] = "<div class='container-block2'><a href='tag.php?id=".$t['id']."'><div class='wrap-item2'><div class='tagtext'>".$t['tag']."</div></div></a></div>";
    }
    $data = array($array, $tags);
    echo json_encode($data);
  
    /*
        
        - zoekresultaten filteren
            * (vrienden eerst vanboven)
            * tags filteren op diegene dat het meest gebruikt worden
                --> in databank kijken bij tabel posts, door descriptions gaan WHERE description LIKE tag, en daar de COUNT van doen
        
    */
?>