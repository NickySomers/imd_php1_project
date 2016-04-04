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
        <div class="container">

            <?php 
                $photo = new Photo();

                $image = $photo->showPhoto();
            
                

                if(!empty($_SESSION['feedback'])){
                    echo $_SESSION['feedback'];
                    unset($_SESSION['feedback']);
                }
            ?>
           
            <div class="upload-form">
              
                <?php if(!empty($image)): ?>
            
                   <div class="image" style="background-image: url(<?php echo $image ?>)"></div>
                
                <?php endif; ?>
                
               <h1>Upload your photo</h1>
               <form action="" method="post" enctype="multipart/form-data">
                   
                   <input type="file" name="image" >
                   <textarea name="description"></textarea>
                   <input type="submit" value="Upload">
                   
               </form>
    
            </div>
            
        </div>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  
        <script>
        

        
        </script>
    </body>

    </html>