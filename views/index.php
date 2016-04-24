<?php
session_start();
include_once("../classes/User.class.php");
	
	//FACEBOOK LOGIN TEST
	
	require_once  '../src/Facebook/autoload.php';
	
	$fb = new Facebook\Facebook([
	  'app_id' => '1020966631330308', // Replace {app-id} with your app id
	  'app_secret' => '6f73476c36bb5ffb9b12aa99fe57b42a',
	  'default_graph_version' => 'v2.2',
	  ]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl('http://localhost:8888/views/fb-callback.php', $permissions);

	



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
				        <?php echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>'; ?>
				    </div>
				    <div class="col-md-6">
				        <a href="register.php">REGISTER</a>
				    </div>
				
				</div>
			</form>
	
		</div>
	</body>
</html>