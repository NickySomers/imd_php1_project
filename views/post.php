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
        <link href="../css/cssgram.min.css" rel="stylesheet">
    </head>

    <body>
       
        <?php
            include_once("header.php");
        ?>
        
        <div class="container">

            <?php
                $photo = new Photo();
                $user = new User();

                $photo->Id = $_GET['id'];
                $photo->getDataFromDatabase();

                $user->Id = $photo->User;
                $user->getDataFromDatabase();
            ?> 

              <div class="wrap-photo" data-index="<?php echo $photo->Id ?>">

                    <div class="header-photo">
                        <div class="profile-pic" style="background-image: url(<?php echo $user->Avatar; ?>)"></div>
                        <div class="profile-name"><a href="profile.php?id=<?php echo $user->Id; ?>"><?php echo $user->Username; ?></a></div>
                        <div class="minutes-posted"><?php echo $photo->Date; ?></div>
                    </div>

                    <?php  $filter = $photo->Filter; if(!empty($filter)): ?>
                        
                        <figure class="<?php echo $photo->Filter; ?>">
                            <img src="<?php echo $photo->Path; ?>" alt="Photo" width="100%" height="auto">
                        </figure>
                        
                    <?php else: ?>
                       
                        <img src="<?php echo $photo->Path; ?>" alt="Photo" width="100%" height="auto">
                        
                    <?php endif; ?>
                    <div class="photo-location"><?php echo $photo->Location; ?></div>
                    <div class="footer-photo">
                        <div class="likes"><span class="likesCount"><?php echo $photo->LikesCount; ?></span> likes</div>
                        <div class="wrap-description">
                            <div class="description-username"><a href="profile.php?id=<?php echo $user->Id; ?>"><?php echo $user->Username;  ?></a></div>
                            <div class="description-text"><?php echo $photo->Description; ?></div>
                        </div>
                        <div class="comments">
                            <?php 
                                $comments = $photo->getComments();

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
                            <?php if($photo->Liked): ?>
                                <div class="liken liked"></div>
                            <?php else: ?>
                                <div class="liken"></div>
                            <?php endif; ?>
                            <input type="text" name="comment" class="comment-input" placeholder="Add a comment...">
                            <div class="flag"></div>
                            <div class="container-report">
                                <div class="wrap-report">
                                    <div class="report" data-index="<?php echo $id; ?>">Report</div>
                                    <div class="report-cancel">Cancel</div>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
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