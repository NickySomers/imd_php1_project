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
        <link rel="stylesheet" href="https://cssgram-cssgram.netdna-ssl.com/cssgram.min.css">
    </head>
    <body>
        
        <header>
            <div class="logo"></div>
        </header>
        
        <div>

            <?php 
                $photo = new Photo();
                $photo->Filter = $_POST['filter'];

                $image = $photo->showPhoto();
            
                if(!empty($_POST['description'])){
                    $photo->upload($_POST["description"], $_SESSION['user']);
                }

                if(!empty($_SESSION['feedback'])){
                    echo '<div class="feedback"><div class="wrapper">'.$_SESSION['feedback'].'</div></div>';
                    unset($_SESSION['feedback']);
                }
            
                if(!empty($_POST['filter']))
                {
                    $filter = $_POST['filter'];                   
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
                                
                            </div>

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

                    </div>

                </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            
            $(document).ready(function(){
                
                /* FILTERS */
                $('.filter-1').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('.filter-1').addClass('active');
                });

                $('.filter-2').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('_1977');
                    $('.filter-2').addClass('active');
                });

                $('.filter-3').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('earlybird');
                    $('.filter-3').addClass('active');
                });

                $('.filter-4').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('hudson');
                    $('.filter-4').addClass('active');
                });

                $('.filter-5').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('aden');
                    $('.filter-5').addClass('active');
                });

                $('.filter-6').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('lofi');
                    $('.filter-6').addClass('active');
                });

                $('.filter-7').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('mayfair');
                    $('.filter-7').addClass('active');
                });

                $('.filter-8').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('nashville');
                    $('.filter-8').addClass('active');
                });

                $('.filter-9').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('rise');
                    $('.filter-9').addClass('active');
                });

                $('.filter-10').click(function () {
                    $('#change-filter').removeClass();
                    $('.filter-1, .filter-2, .filter-3, .filter-4, .filter-5, .filter-6, .filter-7, .filter-8, .filter-9, .filter-10').removeClass('active');
                    $('#change-filter').addClass('walden');
                    $('.filter-10').addClass('active');
                });
                /* END FILTERS */

                $("#publish").click(function () {
                    var className = $('#change-filter').attr("class");
                    $(".input-filter").attr('value', className);
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
                
            });
        </script>
        
    </body>
</html>