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
			
			
			
		?>
	</body>
</html>