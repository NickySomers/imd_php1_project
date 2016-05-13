<?php 

    if(empty($_GET['id'])){
        
        header("Location: index.php");
        
    }
session_start();

include_once("../classes/User.class.php");

$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

        $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
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
        <?php include_once("header.php"); ?>
            <header>
                <div class="logo"></div>
            </header>

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
                    <div class="profileFollow">
                        <?php

                        $followed = $conn->query("SELECT COUNT(*) As test FROM users_followers WHERE userId = 21 AND followUserId = 2 ");
                        $result= $followed->fetch(PDO::FETCH_ASSOC);

                        if($result['test'] == 0){
                            echo'<input id="follow" name="follow" type="submit" value="follow" >';
                            echo '<input id="unfollow" name="following" type="submit" value="following" style="display:none;">';
                        }
                        elseif($result['test'] == 1){
                            echo '<input id="unfollow" name="following" type="submit" value="following">';
                            echo'<input id="follow" name="follow" type="submit" value="follow" style="display: none">';
                        }

                        ?>

                    </div>
                </div>



                <div class="overlay"></div>
                </div>
            <div class="profile-grid container-fluid">
                <div class="wrapper">

                    <?php

                    foreach ($data as $row) {
                        
                        echo '<div class="col-md-4 profile-grid-image-container"><div class="profile-grid-image" style="background-image: url('.$row['picturePath'].')"> test <input type="submit" value="delete Photo" name="deletePic"></div></div>';
                    }
                
                ?>

                </div>

            </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            $("#follow").click(function () {
                $.ajax({
                    url: "../ajax/followProfile.php",
                    method:"POST",
                    data:{ userId: <?php echo $_GET['id'] ?> }
                }).done(function() {

                    $("#follow").hide();
                    $("#unfollow").show();
                });

            });$("#unfollow").click(function () {
                $.ajax({
                    url: "../ajax/unfollowProfile.php",
                    method:"POST",
                    data:{ userId: <?php echo $_GET['id'] ?> }
                }).done(function() {
                    //alert("het werkt");
                    $("#unfollow").hide();
                    $("#follow").show();
                });

            });


        </script>

        </body>

    </html>