<?php
include_once("../classes/user.class.php");

if (!empty($_POST)) {
	$login = new user;
	$username = strip_tags($_POST['login_email']);
	$password = strip_tags($_POST['login_password']);

	$username = stripslashes($username);
	$password = stripslashes($password);


	$login -> CanLogin($username,$password);

}
?><!DOCTYPE html>
<html>
	<head>
		<title>IMDstagram</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body class="home">
		<div class="overlay"></div>
		<div class="login">

			<form action="" method="post">
				<label for="email">E-mail</label>
				<input type="text" name="login_email" class="textfield" placeholder="E-mail">
				<label for="password">Password</label>
				<input type="password" name="login_password" class="textfield" placeholder="Password">
				<input type="submit" class="button" value="Log in">
			</form>
	
		</div>
	</body>
</html>