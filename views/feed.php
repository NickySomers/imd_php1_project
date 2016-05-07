<?php
      
    session_start();

    if(empty($_SESSION['user']))
    {
        header("Location: index.php");
    }

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userN = $_SESSION['user'];
    $posts = $conn->query("SELECT p . *, u . *, p.description pdescription, p.id pid FROM users_followers uf, posts p, users u WHERE uf.followUserId = '$userN' AND uf.userId = p.userId AND uf.userId = u.id ORDER BY p.id DESC LIMIT 2");
            
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

    <?php
                
        $rowCount = $posts->rowCount();
                       
        while($row = $posts->fetch(PDO::FETCH_ASSOC))
        { 
            $id = $row['pid'];

    ?>
                    
            <div class="wrap-photo" data-index="<?php echo $row['pid']; ?>">
                <div class="header-photo">
                    <div class="profile-pic"></div>
                    <div class="profile-name"><?php echo $row['username']; ?></div>
                    <div class="minutes-posted"><?php echo $row['date']; ?></div>
                </div>
                <img src="<?php echo $row['picturePath']; ?>" alt="Photo" width="100%" height="auto">
                <div class="footer-photo">
                    <div class="likes">test</div>
                    <div class="wrap-description">
                        <div class="description-username"><?php echo $row['username']; ?></div>
                        <div class="description-text"><?php echo $row['pdescription']; ?></div>
                    </div>
                    <div class="line"></div>
                    <div class="wrap-liken">
                        <div class="liken"></div>
                        <input type="text" name="comment" class="comment" placeholder="Add a comment...">
                        <div class="flag"></div>
                    </div>
                </div>
            </div>
                        
            <div class="container-report">
                <div class="wrap-report">
                    <div class="report" data-size="0">Report</div>
                    <div class="report-cancel">Cancel</div>
                </div>   
            </div>

    <?php 
                
        } 
            
    ?>

        <div class="show_more_main" id="show_more_main">
            <span data-index="<?php echo $id; ?>" class="show_more" title="Load more posts">Show more</span>
            <span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span>
        </div>
      
    </div>
           
    <!-- JQUERY & JAVASCRIPT --> 
    <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
    <script src="../js/script.js"></script>
            
</body>
</html>