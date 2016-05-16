<?php

    /* DATABANK CONNECTION */
    include_once("../classes/Db.class.php");
    $db = new Db();
    $conn = $db->connect();

    $key = $_POST['input'];
    $users = array();
    $tags = array();
    $locations = array();

    $user = $conn->query("SELECT *, (SELECT COUNT(*) FROM users_followers WHERE userId = u.id) AS followers FROM users u WHERE username LIKE '%{$key}%' OR firstname LIKE '%{$key}%' OR lastname LIKE '%{$key}%' ORDER BY followers DESC LIMIT 10");

    $tag = $conn->query("SELECT * FROM posts_tags WHERE tag LIKE '%{$key}%' LIMIT 10");

    $location = $conn->query("SELECT * FROM posts WHERE location LIKE '%".$key."%' LIMIT 10");

    while($u = $user->fetch(PDO::FETCH_ASSOC))
    {
        $users[] = "<a href='profile.php?id=".$u['id']."'><div class='container-block'><div class='wrap-item'><div class='search-pic' style='background-image: url(".$u['profilePicture'].")'></div><div class='utext'><p class='name'>".$u['firstname']." ".$u['lastname']."</p><p>@".$u['username']."</p></div></div></a>";
    }

    while($t = $tag->fetch(PDO::FETCH_ASSOC))
    {
        $tags[] = "<div class='container-block'><a href='search.php?q=".$t['tag']."'><div class='wrap-item full-width'><div class='tagtext'>#".$t['tag']."</div></div></a></div>";
    }

    while($l = $location->fetch(PDO::FETCH_ASSOC))
    {
        $locations[] = "<div class='container-block'><a href='search.php?q=".$l['location']."'><div class='wrap-item full-width'><div class='locationtext'>".$l['location']."</div></div></a></div>";
    }

    $data = array($users, $tags, $locations);
    echo json_encode($data);
  
?>