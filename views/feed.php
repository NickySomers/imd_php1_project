<?php
            
    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $posts = $conn->query("SELECT p . * , u . * FROM posts p, users_followers u WHERE p.userId = u.followUserId");
            
?><!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>IMDstagram</title>
        <link rel="stylesheet" href="../css/style.css">
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

        <body>
           
            <header>
                <div class="logo"></div>
            </header>
            
            <div class="container">
            
            <?php foreach($posts as $row): ?>
                             
                <div class="wrap-photo">
                    <div class="header-photo">
                        <div class="profile-pic"></div>
                        <div class="profile-name">arnodedecker</div>
                        <div class="minutes-posted"><?php echo $row['date']; ?></div>
                    </div>
                    <img src="<?php echo $row['picturePath']; ?>" alt="Photo" width="100%" height="auto">
                    <div class="footer-photo">
                        <div class="likes"><?php echo $row['description']; ?></div>
                        <div class="wrap-description">
                            <div class="description-username">arnodedecker</div>
                            <div class="description-text"><?php echo $row['description']; ?></div>
                        </div>
                        <div class="line"></div>
                        <div class="wrap-liken">
                            <div class="liken"></div>
                            <input type="text" name="comment" class="comment" placeholder="Add a comment...">
                            <div class="dots"></div>
                        </div>
                    </div>
                </div>
                
            <?php endforeach; ?>
            
            </div>
            
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
            <script src="../js/script.js"></script>
            
        </body>

</html>