<?php
      
    session_start();

    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }else{

        spl_autoload_register(function ($class) {
            include_once '../classes/' . $class . '.class.php';
        });   

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

    <body>
       
        <?php
            include_once("header.php");
        ?>
        
        <div class="container">

            <?php
                $user = new User();
                $posts = $user->loadFeed();

                if(count($posts) == 0):
            ?>

                <p>No post founded yet.</p>

            <?php 
                else:

                    for($i = 0; $i < count($posts); $i++):

                        $postUser = new User();
                        $id = $posts[$i]->Id;

                        $postUser->getDataFromDatabase($posts[$i]->User);

            ?>
                <div class="wrap-photo" data-index="<?php echo $id; ?>">
                    <div class="header-photo">
                        <div class="profile-pic" style="background-image: url(<?php echo $postUser->Avatar; ?>)"></div>
                        <div class="profile-name"><?php echo $postUser->Username; ?> </div>
                        <div class="minutes-posted"><?php echo $posts[$i]->Date; ?></div>
                    </div>
                    <img src="<?php echo $posts[$i]->Path; ?>" alt="Photo" width="100%" height="auto">
                    <div class="footer-photo">
                        <div class="likes"><span class="likesCount"><?php echo $posts[$i]->LikesCount; ?></span> likes</div>
                        <div class="wrap-description">
                            <div class="description-username"><?php echo $postUser->Username;  ?></div>
                            <div class="description-text"><?php echo $posts[$i]->Description; ?></div>
                        </div>
                        <div class="line"></div>
                        <div class="wrap-liken">
                            <div class="liken"></div>
                            <input type="text" name="comment" class="comment" placeholder="Add a comment...">
                            <div class="dots"></div>
                        </div>
                    </div>
                </div>

            <?php endfor; endif; ?>

            <div class="show_more_main" id="show_more_main">
                <span data-index="<?php echo $id; ?>" class="show_more" title="Load more posts">Show more</span>
                <span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span>
            </div>

        </div>
        
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="../js/script.js"></script>
            
    </body>
</html>