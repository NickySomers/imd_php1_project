<?php
    $key = $_GET['key'];
    $array = array();

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $conn->query("SELECT * FROM users WHERE username LIKE '%{$key}%'");

    while($row = $query->fetch(PDO::FETCH_ASSOC))
    {
        $array[] = $row['username'];
    }

    echo json_encode($array);
?>