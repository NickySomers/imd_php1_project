<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$results = $conn ->query("SELECT comment FROM posts_comments WHERE postId = 3");
$result= $results->fetch(PDO::FETCH_ASSOC);
var_dump($result);
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="comment" class="comment" placeholder="Add a comment...">

</form>
</body>
</html>