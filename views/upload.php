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

    <?php 
        
    $photo = new Photo();

    $image = $photo->showPhoto();
    
    if(!empty($_POST['filter']))
    {
        $photo->Filter = $_POST['filter'];
    }
            
    if(!empty($_POST['description']))
    {
        $photo->upload($_POST["description"], $_SESSION['user']);
    }

    if(!empty($_SESSION['feedback']))
    {
        echo '<div class="feedback"><div class="wrapper">'.$_SESSION['feedback'].'</div></div>';
        unset($_SESSION['feedback']);
    }
        
    ?>


    <div class="container-fluid">
                   
        <div class="upload-container">

        <?php if(empty($image)): ?>
                        
            <!-- Photo upload screen -->
            <div class="wrapper upload-form">
                <h1>Upload your photo</h1>
                <form action="" method="post" enctype="multipart/form-data" id="form-upload">
                    <input type="file" id="file" name="image" accept=".jpg,.png">
                </form>
            </div>
                            
        <?php else: ?>
                                
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
                    <form action="" method="post" id="publish-form">
                        <input type="text" name="image" hidden value="<?php echo $image; ?>">
                        <input class="input-filter" type="text" name="filter" hidden value="">
                        <textarea name="description" class="image-description-field"></textarea>
                    </form>
                    <div class="button-group">
                        <button type="button" id="anotherPhoto" class="button custom-button">Cancel</button>
                        <button type="button" id="publish" class="button custom-button">Publish</button>
                    </div>
                </div>
            </div>

        <?php endif; ?>
                        
            <!-- Blurry background of the uploaded image -->
            <?php if(empty($image)): ?>
                <div class="image-background"></div>
            <?php else: ?>
                <div class="image-background" style="background-image: url(<?php echo $image; ?>)"></div>
            <?php endif; ?>

        </div> <!-- END upload-container -->

    </div> <!-- END container-fluid -->

    <!-- JAVASCRIPT AND JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
        
</body>
</html>