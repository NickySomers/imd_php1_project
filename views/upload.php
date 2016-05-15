<?php
	session_start();
    if(empty($_SESSION['user']))
    {
        header("Location: index.php");
    }

	//Include all classes
	spl_autoload_register(function ($class) {
		include '../classes/' . $class . '.class.php';
	});
        
    $photo = new Photo();

    if(!empty($_POST['description'])){
        $photo->Location = $_POST['coordinates'];
        $photo->Filter = $_POST['filter'];
        $photo->upload($_POST["description"], $_SESSION['user'], $_FILES['image']);
    }     
?>


<html lang="en">
<head>
    <title>Upload | IMDstagram</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/cssgram.min.css">
</head>
<body>

    <?php include_once("header.php"); ?>


    <div class="container-fluid">
                   
        <div class="upload-container">

                        
            <!-- Photo upload screen -->
            <div class="wrapper upload-form">
                <h1>Upload your photo</h1>
            </div>

                                

            <div class="wrapper-image-filter">
                                
                <!-- Uploaded image preview -->
                <div id="change-filter">
                    <div class="image" style="background-image:url(<?php echo $image ?>)"></div>
                </div>
                            
                <!-- Filters -->
                <div class="wrap-filters">
                    <div class="filter filter-1">
                        <figure>
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-2">
                        <figure class="_1977">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-3">
                        <figure class="earlybird">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-4">
                        <figure class="hudson">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-5">
                        <figure class="aden">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-6">
                        <figure class="lofi">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-7">
                        <figure class="mayfair">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-8">
                        <figure class="nashville">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-9">
                        <figure class="rise">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                    <div class="filter filter-10">
                        <figure class="walden">
                            <div class="image-filter" style="background-image:url(<?php echo $image ?>)"></div>
                        </figure>
                    </div>
                </div>
                                
            </div> <!-- END wrapper-image-filter -->

            <!-- Form to add a description to your uploaded photo -->
            <div class="add-image-info">
                <div class="content">
                    <form action="" method="post" id="publish-form" enctype="multipart/form-data">
                    <input type="file" id="file" name="image" accept=".jpg,.png">
                        <input type="text" name="image" id="image-field" hidden>
                        <input class="input-filter" type="text" name="filter" hidden value="">
                        <input type="text" name="coordinates" id="coords" hidden>
                        <textarea name="description" class="image-description-field"></textarea>
                    </form>
                    <div class="button-group">
                        <button type="button" id="anotherPhoto" class="button custom-button">Cancel</button>
                        <button type="button" id="publish" class="button custom-button">Publish</button>
                    </div>
                </div>
            </div>

 
                        
            <!-- Blurry background of the uploaded image -->

                <div class="image-background"></div>
  

        </div> <!-- END upload-container -->

    <script>


        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
            var coordinates = position.coords.latitude + ","+ position.coords.longitude; 
            $("#coords").val(coordinates);
        }

    </script>

    <!-- JAVASCRIPT AND JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
        
</body>
</html>