<?php
	session_start();

	//Include all classes
	spl_autoload_register(function ($class) {
		include '../classes/' . $class . '.class.php';
	});
?>
    <html>

    <head>
        <title>IMDstagram</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/style.css">
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <div class="logo"></div>
        </header>
        
        <div>

            <?php 
                $photo = new Photo();

                $image = $photo->showPhoto();
            
                if(!empty($_POST['description'])){
                    $photo->upload();
                }

                if(!empty($_SESSION['feedback'])){
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
                                
                            <!-- Uploaded image preview -->
                            <div class="image-container">
                                <img class="image" src="<?php echo $image ?>">
                            </div>

                            <!-- Form to add a description to your uploaded photo -->
                            <div class="add-image-info">
                                <div class="content">
                                    <form action="" method="post" id="publish-form">
                                        <input type="text" name="image" hidden value="<?php echo $image; ?>">
                                        <textarea name="description" class="image-description-field"></textarea>

                                    </form>
                                    <div class="button-group">

                                        <button type="button" id="anotherPhoto" class=" button custom-button">Cancel</button>
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

                    </div>


                </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            $("#publish").click(function () {

                $("#publish-form").submit();

            });
            
            $("#anotherPhoto").click(function () {

                location.href="index.php";
            });

            $('#form-upload').submit(function () {
                var queryString = new FormData($('form')[0]);
                $.ajax({
                    type: "POST",
                    url: 'upload.php',
                    data: queryString,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {},
                    success: function () {}
                });
            });

            $("#file").change(function () {
                $("#form-upload").submit();
            });
        </script>
    </body>

    </html>