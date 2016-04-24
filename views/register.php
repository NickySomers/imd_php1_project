<?php 
    session_start();

    include_once("../classes/User.class.php");
	require_once  '../src/Facebook/autoload.php';

    if(!empty($_POST))
    {
        try
        {  
            $user = new User();
		    $user->register($_POST['firstname'], $_POST['lastname'], $_POST['register_email'], $_POST['register_password'], $_POST['confirm_register_password']);
        }
        catch(exception $e)
        {
            $error = $e->getMessage();
        }
	}

	if(!empty($_GET['login']) && $_GET['login'] == "fb"){
		$user = new User();
		$data = $user->signUpWithFb(); 
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
                <?php if(isset($error) && !empty($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
                
                <label for="firstname">First name</label>
				<?php if(!empty($data)): ?>
					<input type="text" name="firstname" class="textfield" placeholder="First name" value="<?php echo $data['firstname']; ?>">
				<?php else: ?>
					<input type="text" name="firstname" class="textfield" placeholder="First name">
				<?php endif;?>

                <label for="lastname">Last name</label>
				<?php if(!empty($data)): ?>
					<input type="text" name="lastname" class="textfield" placeholder="Last name" value="<?php echo $data['firstname']; ?>">
				<?php else: ?>
					<input type="text" name="lastname" class="textfield" placeholder="Last name">
				<?php endif;?>

				<label for="register_email">E-mail</label>
				<?php if(!empty($data)): ?>
					<input type="text" name="register_email" class="textfield" placeholder="E-mail" value="<?php echo $data['email']; ?>">
				<?php else: ?>
					<input type="text" name="register_email" class="textfield" placeholder="E-mail">
				<?php endif;?>

				<label for="register_password">Password</label>
				<input type="password" name="register_password" class="textfield" placeholder="Password">
                <label for="confirm_register_password">Confirm password</label>
				<input type="password" name="confirm_register_password" class="textfield" placeholder="Confirm password">
				<input type="submit" class="button" value="Register">
			</form>
			<?php

				$fb = new Facebook\Facebook([
				  'app_id' => '1020966631330308', // Replace {app-id} with your app id
				  'app_secret' => '6f73476c36bb5ffb9b12aa99fe57b42a',
				  'default_graph_version' => 'v2.2',
				  ]);

				$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email']; // Optional permissions
				$loginUrl = $helper->getLoginUrl('http://localhost:8888/views/register.php?login=fb', $permissions);

			?>

			<a href="<?php echo $loginUrl; ?>">REGISTER WITH FACEBOOK</a>
		</div>
	</body>
</html>