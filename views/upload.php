<?php
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
	</head>
	<body>
		<?php 
			$photo = new Photo();
			$photo->uploadPhoto();
		?>

		<form action="" method="post" enctype="multipart/form-data">

		<input type="file" name="image" >
		<textarea name="description"></textarea>
		<input type="submit" value="Upload">

		</form>

	</body>
</html>