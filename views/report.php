<?php

    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $reports = $conn->query("SELECT * FROM reports");
            
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
            
    <div class="profile-grid container-fluid">
        
        <div class="wrapper">

        <?php

            foreach ($reports as $row) 
            {
                if($row['reportCount'] == 3)
                {
                    echo '<div class="col-md-4 profile-grid-image-container"><div class="profile-grid-image" style="background-image: url('.$row['reportPath'].')"></div></div>';   
                }
                else
                {
                    
                }
            }
                
        ?>

        </div>

    </div>
           
    <!-- JQUERY & JAVASCRIPT --> 
    <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
    <script src="../js/script.js"></script>
            
</body>
</html>