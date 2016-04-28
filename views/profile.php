<?php 

    if(empty($_GET['id'])){
        
        header("Location: index.php");
        
    }

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>IMDstagram</title>
        <link rel="stylesheet" href="../css/style.css">
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <?php
  
    //CHANGE TO FUNCTION IN USER CLASS
    try {

        $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = $conn->query("SELECT * FROM posts WHERE userId = ".$_GET['id']." ORDER BY date DESC"); 
        $userdata = $conn->query("SELECT * FROM users WHERE id = ".$_GET['id']); 
        $followingdata = $conn->query("SELECT * FROM users_followers WHERE userId = ".$_GET['id']); 
        $followersdata = $conn->query("SELECT * FROM users_followers WHERE followUserId = ".$_GET['id']); 
        
        foreach ($userdata as $row) {

            $name = $row['firstname'] . " " . $row['lastname'];
            $username = $row['username'];
            $profile = $row['profilePicture'];
            
        }
        $count_photos = $data->rowCount();
        $count_followers = $followersdata->rowCount();
        $count_following = $followingdata->rowCount();

    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    
?>

        <body>
            <?php
                include_once("header.php");
            ?>

            <div class="profile-header">
                <div class="wrapper">

                    <div class="profile-picture" style="background-image: url(<?php echo $profile; ?>)"></div>
                    <div>
                        <h1><?php echo $name; ?></h1>
                        <h2>@<?php echo $username; ?></h2>
                    </div>
                </div>
                <div class="profile-information">
                    <div class="profile-information-item">
                        <span>Photos</span>
                        <span class="amount"><?php echo $count_photos; ?></span>
                    </div>
                    <div class="profile-information-item">
                        <span>Followers</span>
                        <span class="amount"><?php echo $count_followers; ?></span>
                    </div>
                    <div class="profile-information-item">
                        <span>Following</span>
                        <span class="amount"><?php echo $count_following; ?></span>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
            <div class="profile-grid container-fluid">
                <div class="wrapper">

                    <?php

                    foreach ($data as $row) {
                        
                        echo '<div class="col-md-4 profile-grid-image-container"><div class="profile-grid-image" style="background-image: url('.$row['picturePath'].')">Test</div></div>';
                    }
                
                ?>

                </div>

            </div>
        </body>

    </html>