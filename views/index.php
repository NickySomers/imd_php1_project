<?php
session_start();
include_once("../classes/User.class.php");
include_once('../php/facebook/src/Facebook/autoload.php');

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
			<div class="logo"></div>
			<form action="" method="post">
				<label for="login_email">E-mail</label>
				<input type="text" name="login_email" class="textfield" placeholder="E-mail">
				<label for="login_password">Password</label>
				<input type="password" name="login_password" class="textfield" placeholder="Password">
				<div class="button-group">
					<div class="grid">
						<input type="submit" class="button" value="Log in">
						<?php
							$fb = new Facebook\Facebook([
							  'app_id' => '1020966631330308', // Replace {app-id} with your app id
							  'app_secret' => '82ec1625a31d76812feeeab549b7c8c9',
							  'default_graph_version' => 'v2.2',
							  ]);

							$helper = $fb->getRedirectLoginHelper();

							$permissions = ['email']; // Optional permissions
							$loginUrl = $helper->getLoginUrl('http://imdstagram.wearestrong.be/views/fb-callback.php', $permissions);
// $loginUrl = $helper->getLoginUrl('http://localhost:8888/views/fb-callback.php', $permissions);
							echo '<a href="' . htmlspecialchars($loginUrl) . '" class="button"><i class="fa fa-facebook-official" aria-hidden="true"></i>Login with facebook</a>';
						?>
						
					</div>
					<a href="register.php" class="button" >Sign up</a>
				</div>
			</form>
	
		</div>
		<script src="https://use.fontawesome.com/124768e08b.js"></script>
	</body>
</html>