<!DOCTYPE html>
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

            <?php
            
                $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $posts = $conn->query("SELECT * FROM posts");
            
            ?>
            
            <?php foreach($posts as $post): ?>
                
               <?php //$followers = $conn->query("SELECT * FROM posts"); ?>
                
                <div class="container">
                    <div class="wrap-photo">
                        <div class="header-photo">
                            <div class="profile-pic"></div>
                            <div class="profile-name">tester</div>
                            <div class="minutes-posted">50 m.</div>
                        </div>
                        <img src="<?php echo $post['picturePath']; ?>" alt="Photo" width="100%" height="auto">
                    </div>
                </div>
                
            <?php endforeach; ?>
            
            
        </body>

    </html>