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
        
        $db = new Db();
        $conn = $db->connect();
    }

?><!DOCTYPE html>
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
         
        <div class="profile-grid container-fluid">
            <div class="wrapper">
            <?php

                $tag = $conn->query("SELECT * FROM posts WHERE description LIKE '%#".$_GET['q']."%'");
                
                if($tag->rowCount() > 0)
                {
                    while($row = $tag->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="title-tags">Tags</div>';
                        echo '<div class="col-md-4 profile-grid-image-container"><figure class='.$row['filter'].'><div class="profile-grid-image" style="background-image: url('.$row['picturePath'].')"></div></figure></div>';
                    }
                }
                
            ?>
            </div>
        </div>
         
        <div class="profile-grid container-fluid">
            <div class="wrapper">
            <?php
                
                $location = $conn->query("SELECT * FROM posts WHERE location LIKE '%".$_GET['q']."%'");

                if($location->rowCount() > 0)
                {
                    while($row = $location->fetch(PDO::FETCH_ASSOC))
                    {
                        echo '<div class="title-tags">Locations</div>';
                        echo '<p id="location">'.$_GET['q'].'</p>';
                        echo '<div id="map"></div>';
                        echo '<div class="col-md-4 profile-grid-image-container"><figure class='.$row['filter'].'><div class="profile-grid-image" style="background-image: url('.$row['picturePath'].')"></div></figure></div>';
                    }
                }

            ?>
            </div>
        </div>
          
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh_xS_8wsg53h_8Zb6nPbgj1_j8AMb84s&callback=initialize" async defer></script>
        <script>
            
            var geocoder;
            var map;
            function initialize() {
                geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(-34.397, 150.644);
                var mapOptions = {
                    zoom: 8,
                    center: latlng,
                    disableDefaultUI: true
                }
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
            
                var address = document.getElementById("location").innerHTML;
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
            
            initialize();
            
        </script>
        
</body>

</html>