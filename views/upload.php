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
                    echo $_SESSION['feedback'];
                    unset($_SESSION['feedback']);
                }
            ?>


                <div class="container-fluid">
                    <div class="image-container">

                        <?php if(empty($image)): ?>

                            <form action="" method="post" enctype="multipart/form-data" id="form-upload">

                                <input type="file" id="file" name="image" accept=".jpg,.png">

                            </form>

                            <?php else: ?>

                                <img class="image" src="<?php echo $image ?>">
                                <div class="add-image-info">
                                    <div class="content">
                                        <form action="" method="post" id="publish-form">
                                            <input type="text" name="image" hidden value="<?php echo $image; ?>">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="image-description-field"></textarea>

                                        </form>
                                        <div class="button-group">

                                            <button type="button" class="custom-button gray">Another photo</button>
                                            <button type="button" id="publish" class="custom-button">Publish</button>

                                        </div>
                                    </div>
                                </div>


                                <div class="image-background" style="background-image: url(<?php echo $image; ?>)">







                                </div>



                                <?php endif; ?>

                    </div>


                </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            $("#publish").click(function () {

                $("#publish-form").submit();

            })

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