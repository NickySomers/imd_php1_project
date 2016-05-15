<?php
      
    session_start();

    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }else{

        spl_autoload_register(function ($class) {
            include_once '../classes/' . $class . '.class.php';
        });   

        $user = new User();
        $user->Id = $_GET['id'];
        if($user->checkIfUserExists()){
            $user->getDataFromDatabase();
        }else{
            header("Location: 404.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>IMDstagram</title>
        <link rel="stylesheet" href="../css/style.css">
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/cssgram.min.css" rel="stylesheet">
    </head>

    <body data-profile="<?php echo $user->Id; ?>">

        <?php include_once("header.php"); ?>

        <div class="profile-header" style="background-image: url(<?php echo $user->Header; ?>);">


            <div class="user-info">
                <div class="profile-picture" style="background-image: url(<?php echo $user->Avatar; ?>)"></div>

                <div class="content">
                    <h1><?php echo $user->Firstname . " " . $user->Lastname; ?> </h1>
                    <div class="profile-follow">
                    <?php

                        if($user->checkFollow()){
                            echo'<input id="follow" name="follow" type="submit" value="follow"  class="button">';
                            echo '<input id="unfollow" name="following" type="submit" value="following" style="display:none;" class="button">';
                        }else{
                            echo'<input id=
                            "follow" name="follow" type="submit" value="follow" style="display:none;" class="button">';
                            echo '<input id="unfollow" name="following" type="submit" value="following" class="button">';
                        }

                    ?>
                    </div>
                    <?php if($user->Private): ?>
                        <h2>@<?php echo $user->Username; ?><i class="fa fa-lock" aria-hidden="true"></i></h2>
                    <?php else: ?>
                        <h2>@<?php echo $user->Username; ?></h2>
                    <?php endif; ?>
                    
                    
                </div>
            </div>
            <div class="profile-information">
                <div class="profile-information-item">
                    <span>Photos</span>
                    <span class="amount"><?php echo $user->PhotosCount; ?></span>
                </div>
                <div class="profile-information-item">
                    <span>Followers</span>
                    <span class="amount"><?php echo $user->FollowersCount; ?></span>
                </div>
                <div class="profile-information-item">
                    <span>Following</span>
                    <span class="amount"><?php echo $user->FollowingCount; ?></span>
                </div>

                <?php if($user->Id != $_SESSION['user']): ?>
   
                <?php endif; ?>
            </div>
            <div class="overlay"></div>
        </div>
        <div class="profile-grid container-fluid">
            <div class="wrapper">
            <?php

                $posts = $user->loadProfile();

                if(count($posts) == 0):
                    echo "<p>There are no posts at this moment</p>";
                else: 

                for($i = 0; $i < count($posts); $i++):
                    $filter = $posts[$i]->Filter;
                    if(!empty($filter)){
                        echo '<a href="post.php?id='.$posts[$i]->Id.'"><div class="col-md-4 profile-grid-image-container" data-index="'.$posts[$i]->Id.'"><figure class="'.$filter.'"><div class="profile-grid-image" style="background-image: url('.$posts[$i]->Path.')"></div></figure></div></a>';
                    }else{
                        echo '<a href="post.php?id='.$posts[$i]->Id.'"><div class="col-md-4 profile-grid-image-container" data-index="'.$posts[$i]->Id.'"><div class="profile-grid-image" style="background-image: url('.$posts[$i]->Path.')"></div></div></a>';
                    }
                    


                endfor; endif;

            ?>
            </div>
            <div class="post-detail">
                <div class="picture"></div>
                <div class="info">
                    <div class="user">
                        <p class="username"></p>
                    </div>
                    <div class="likes">
                        <p class="likesCount"></p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/script.js"></script>
        <script>
            $("#follow").click(function () {
                $.ajax({
                    url: "../ajax/followProfile.php",
                    method:"POST",
                    data:{ userId: $("body").attr("data-profile") }
                }).done(function() {

                    $("#follow").hide();
                    $("#unfollow").show();
                });

            });

            $("#unfollow").click(function () {
                $.ajax({
                    url: "../ajax/unfollowProfile.php",
                    method:"POST",
                    data:{ userId: $("body").attr("data-profile")}
                }).done(function() {
                    //alert("het werkt");
                    $("#unfollow").hide();
                    $("#follow").show();
                });
            });

            // $(".profile-grid-image-container").click(function () {
            //     var data = {
            //         id: $(this).attr("data-index")
            //     }

            //     $.ajax({
            //         url: "../ajax/showPostInfo.php",
            //         method: "POST",
            //         data: data
            //     }).done(function(res) {
            //         var data = $.parseJSON(res);
            //         $(".post-detail").css("display", "flex");
            //         $(".post-detail .picture").css("background-image", "url("+data["path"]+")");
            //         $(".post-detail .username").text(data["username"]);
            //         $(".post-detail .likesCount").text(data["likes"]);
            //     });
            // });

        </script>
</body>

</html>