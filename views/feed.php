<?php
      
    session_start();

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userN = $_SESSION['user'];
    $posts = $conn->query("SELECT p . *, u . *, p.description pdescription FROM users_followers uf, posts p, users u WHERE uf.followUserId = '$userN' AND uf.userId = p.userId AND uf.userId = u.id ORDER BY p.date DESC LIMIT 1");
            
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
            
            <?php //foreach($posts as $row): ?>
                             
                <!--<div class="wrap-photo">
                    <div class="header-photo">
                        <div class="profile-pic"></div>
                        <div class="profile-name"><?php //echo $row['username']; ?></div>
                        <div class="minutes-posted"><?php //echo $row['date']; ?></div>
                    </div>
                    <img src="<?php //echo $row['picturePath']; ?>" alt="Photo" width="100%" height="auto">
                    <div class="footer-photo">
                        <div class="likes">test</div>
                        <div class="wrap-description">
                            <div class="description-username"><?php //echo $row['username']; ?></div>
                            <div class="description-text"><?php //echo $row['pdescription']; ?></div>
                        </div>
                        <div class="line"></div>
                        <div class="wrap-liken">
                            <div class="liken"></div>
                            <input type="text" name="comment" class="comment" placeholder="Add a comment...">
                            <div class="dots"></div>
                        </div>
                    </div>
                </div>-->
                
            <?php //endforeach; ?>
            
            
            
            
            
            
            
            
                
                
                    <?php



                    //number of rows
                    $rowCount = $posts->rowCount();

                    if($rowCount > 0)
                    { 
                        while($row = $posts->fetch(PDO::FETCH_ASSOC))
                        { 
                            $tutorial_id = $row['date'];
                    ?>
                        <div class="wrap-photo">
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
                                    <div class="dots"></div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="show_more_main" id="show_more_main<?php echo $tutorial_id; ?>">
                        <span id="<?php echo $tutorial_id; ?>" class="show_more" title="Load more posts">Show more</span>
                        <span class="loding" style="display: none;"><span class="loding_txt">Loading....</span></span>
                    </div>

                    <?php } ?>
                    
          
            
                <?php
                if(isset($_POST["id"]) && !empty($_POST["id"]))
                {
                    //count all rows except already displayed
                    $queryAll = $conn->query("SELECT COUNT(*) as num_rows FROM posts WHERE id < '".$_POST['id']."' ORDER BY id DESC");
                    $row = $queryAll->fetch(PDO::FETCH_ASSOC);
                    $allRows = $row['num_rows'];

                    $showLimit = 1;
                    
                    //get rows query
                    $posts = $conn->query("SELECT * FROM posts WHERE id < '".$_POST['id']."' ORDER BY id DESC LIMIT ".$showLimit);

                    //number of rows
                    $rowCount = $posts->rowCount();

                    if($rowCount > 0)
                    { 
                        while($row = $posts->fetch(PDO::FETCH_ASSOC))
                        { 
                            $tutorial_id = $row["id"]; ?>
                            <div class="wrap-photo">
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
                                        <div class="dots"></div>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
                    <?php if($allRows > $showLimit){ ?>
                        <div class="show_more_main" id="show_more_main<?php echo $tutorial_id; ?>">
                            <span id="<?php echo $tutorial_id; ?>" class=“show_more” title="Load more posts">Show more</span>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading….</span></span>
                        </div>
                    <?php } ?>  
                    <?php 
                        } 
                }
                ?>
            
            
            
            
            
            </div>
            
            <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
            <script src="../js/script.js"></script>
            
        </body>

</html>