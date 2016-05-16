<?php
      
    session_start();

    if(empty($_SESSION['user']))
    {
        header("Location: index.php");
    }
    else
    {
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
        <link href="../css/cssgram.min.css" rel="stylesheet">
    </head>

    <body>
       
        <?php include_once("header.php"); ?>
        
        <div class="container">

            <?php
                $user = new User();
                $posts = $user->loadFeed();

                if(count($posts) == 0):
            ?>
                <div class="noposts-feedback">
                    <h1>No posts found yet.</h1>
                    <p>Follow your friends to see their recent photos here.</p>
                </div>
                

            <?php 
                else:
                    for($i = 0; $i < count($posts); $i++):

                        $postUser = new User();
                        $id = $posts[$i]->Id;
                        $postUser->Id = $posts[$i]->User;
                        $postUser->getDataFromDatabase();

            ?>
                <div class="wrap-photo" data-index="<?php echo $id; ?>">

                    <div class="header-photo">
                        <div class="profile-pic" style="background-image: url(<?php echo $postUser->Avatar; ?>)"></div>
                        <div class="profile-name"><a href="profile.php?id=<?php echo $postUser->Id; ?>"><?php echo $postUser->Username; ?></a></div>
                        <div class="minutes-posted"><?php echo $posts[$i]->Date; ?></div>
                    </div>
                    <div class="photo">
                        <?php  $filter = $posts[$i]->Filter; if(!empty($filter)): ?>
                            
                            <figure class="<?php echo $posts[$i]->Filter; ?>">
                                <img src="<?php echo $posts[$i]->Path; ?>" alt="Photo" width="100%" height="auto">
                            </figure>
                            
                        <?php else: ?>
                           
                            <img src="<?php echo $posts[$i]->Path; ?>" alt="Photo" width="100%" height="auto">
                            
                        <?php endif; ?>
                        <div class="photo-location"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $posts[$i]->Location; ?></div>
                    </div>
                    <div class="footer-photo">
                        <div class="likes"><span class="likesCount"><?php echo $posts[$i]->LikesCount; ?></span> likes</div>
                        <div class="wrap-description">
                            <div class="description-username"><a href="profile.php?id=<?php echo $postUser->Id; ?>"><?php echo $postUser->Username; ?></a></div>
                            <div class="description-text"><?php echo $posts[$i]->Description; ?></div>
                        </div>
                        <div class="comments">
                            <?php 
                                $comments = $posts[$i]->getComments();

                                for($j = 0; $j < count($comments); $j++):
                                    $comment_user = new User();
                                    $comment_user->Id = $comments["userId"];
                                    $comment_user->getDataFromDatabase();
                            ?>
                                <div class="comment">
                                    <p><div class="description-username"><a href="profile.php?id=<?php echo $comment_user->Id; ?>"><?php echo $comment_user->Username; ?></a></div> <?php echo $comments["comment"]; ?></p>
                                </div>
                                
                            <?php endfor; ?>
                        </div>
                        <div class="line"></div>
                        <div class="wrap-liken">
                            <?php if($posts[$i]->Liked): ?>
                                <div class="liken liked"></div>
                            <?php else: ?>
                                <div class="liken"></div>
                            <?php endif; ?>

                            <input type="text" name="comment" class="comment-input" placeholder="Add a comment...">

                            <div class="flag"></div>
                            <div class="wrap-limit"></div>
                            <div class="container-report">
                                <div class="wrap-report">
                                    <div class="report">Report</div>
                                    <div class="report-cancel">Cancel</div>
                                </div>   
                            </div>
                            
                        </div>
                    </div>
                </div>
     

            <?php endfor; ?>

            <div class="show_more_main" id="show_more_main">
                <div data-index="<?php echo $id; ?>" class="spinner show_more">
                      <div class="bounce1"></div>
                      <div class="bounce2"></div>
                      <div class="bounce3"></div>
                </div>
            </div>     

            <?php endif; ?>
                    
        </div>
        
        <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="../js/script.js"></script>
        
        <script>

            $(".comment-input").keyup(function (e) {
                var comment = $(this);
                if (e.keyCode == 13) {
                    
                    var data = {
                        postId: comment.closest( ".wrap-photo" ).attr("data-index"),
                        text: comment.val()
                    }

                    $.post("../ajax/addComment.php", data, function(res) {
                        var data = $.parseJSON(res);
                        comment.parent().parent().find(".comments").append("<div class='comment'><p><div class='description-username'><a href='profile.php?id='>"+data[0]+"</a></div>"+data[1]+"</p></div>");
                        comment.val("");
                    });
                }
            });
        </script>
    </body>
</html>