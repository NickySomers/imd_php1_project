<?php

    session_start();


    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }

    include_once('../classes/User.class.php');
    include_once('../classes/Photo.class.php');
    include_once('../classes/comment.classs.php');

if(isset($_POST['comment']) && isset($_POST['postId'])){
    $comment = new Comment();
    $comment->comment = $_POST['comment'];
    $comment->postId = $_POST['postId'];
    $comment->userId = $_SESSION['user'];
    $comment->newComment();
}

if(isset($_POST['commentId'])){
    $commentId = $_POST['commentId'];
    $comment = new Comment();
    $comment->deleteCommentById($commentId);
}

    $user = new User();


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
           
            <?php include_once('header.php'); ?>

            <div class="container">


                    <?php
                        $posts = Photo::getPosts();
                        //var_dump($posts);

                        foreach($posts as $post)
                        {
                            echo '<div class="minutes-posted">'.$post['date'].'</div></div>';
                            echo '<img src="' . $post['picturePath'] . '" alt="Photo" width="100%" height="auto">';
                            echo '<div class="footer-photo"><div class="likes"><span class="likesCount">Likescount</span> likes</div><div class="wrap-description">';
                            echo '<div class="description-username">Username</div>';
                            //echo '<form action="" method="post"> <div class="photo-comment"> test <input type="button" name="deleteComment" value="delete comment"> </div></form>';

                            $comments = Photo::getCommentsByPostId($post['id']);

                            foreach($comments as $c)
                            {
                                echo '<form action="" method="post">
                                        <div class="photo-comment">' . $c['comment'] . '<input type="text" name="commentId" hidden value="'. $c['id'] . '"><button type="submit">Delete</button> </div></form>';
                            }
                            echo '<form action="" method="post"><input type="text" name="comment" class="comment" placeholder="Add a comment..."> <input type="text" name="postId" value="'.$post['id'].'" hidden ><input type="submit" name="oke" value="oke"></form> <div class="dots"></div>';


                        }

                    ?>


                    <?php

                        /*$posts = $user->loadFeed();
                        $id = 0;

                         for($i = 0; $i < count($posts); $i++){
                            $photo = $posts[$i];
                            $id = $posts[$i]->Id;



                            $photo->display();
                        }*/
                        
                    ?>

                    <div class="show_more_main" id="show_more_main">
                        <span data-index="<?php echo $id; ?>" class="show_more" title="Load more posts">Show more</span>
                        <span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span>
                    </div>

      
            </div>
            
            <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
            <script src="../js/script.js"></script>
            
        </body>

</html>

