<?php      
    session_start();

    if(empty($_SESSION['user'])){
        header("Location: index.php");
    }

    include_once('../classes/User.class.php');
    include_once('../classes/Photo.class.php');
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

                        $posts = $user->loadFeed();
                        $id = 0;

                         for($i = 0; $i < count($posts); $i++){
                            $photo = $posts[$i];
                            $id = $posts[$i]->Id;

                            $photo->display();
                        }
                        
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

