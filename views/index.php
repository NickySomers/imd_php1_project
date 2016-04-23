<?php
session_start();
include_once("../classes/User.class.php");
	

if(!empty($_SESSION['user']))
{
    header("Location: feed.php");
}

if (!empty($_POST)) {
	$login = new User();

	$username = strip_tags($_POST['login_email']);
	$password = strip_tags($_POST['login_password']);

	$username = stripslashes($username);
	$password = stripslashes($password);



	if($login->CanLogin($username,$password)){
		header('Location: feed.php');
	}else{
		echo "Error";
	}

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
				<label for="login_email">E-mail</label>
				<input type="text" name="login_email" class="textfield" placeholder="E-mail">
				<label for="login_password">Password</label>
				<input type="password" name="login_password" class="textfield" placeholder="Password">
				<input type="submit" class="button" value="Log in">
				<div class="container-fluid">
				
				    <div class="col-md-6">
				        LOGIN WITH FACEBOOK
				    </div>
				    <div class="col-md-6">
				        <a href="register.php">REGISTER</a>
				    </div>
				
				</div>
			</form>
	
		</div>
	</body>
</html>