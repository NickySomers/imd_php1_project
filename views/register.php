<?php 

    include_once("../classes/User.class.php");
    include_once('../php/facebook/src/Facebook/autoload.php');
    session_start();
    if(!empty($_POST))
    {
        try
        {  
            $user = new User();
            $user->Firstname = $_POST['firstname'];
            $user->Lastname = $_POST['lastname'];
            $user->Username = $_POST['username'];
            $user->Email = $_POST['register_email'];
            $user->Password = $_POST['register_password'];
            $user->ConfirmPassword = $_POST['confirm_register_password'];
		    $user->register();
        }
        catch(exception $e)
        {
            $error = $e->getMessage();
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
		<div class="signup">
			<form action="" method="post">
                <?php if(isset($error) && !empty($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <label for="firstname">First name</label>
				<input type="text" name="firstname" class="textfield" placeholder="First name">
                <label for="lastname">Last name</label>
				<input type="text" name="lastname" class="textfield" placeholder="Last name">
				<label for="username">Username</label>
				<input type="text" name="username" class="textfield" placeholder="Username">
				<label for="register_email">E-mail</label>
				<input type="text" name="register_email" class="textfield" placeholder="E-mail">
				<label for="register_password">Password</label>
				<input type="password" name="register_password" class="textfield" placeholder="Password">
                <label for="confirm_register_password">Confirm password</label>
				<input type="password" name="confirm_register_password" class="textfield" placeholder="Confirm password">
				
                <div class="button-group">
     
                        <input type="submit" class="button" value="Register">
                        <?php
                            $fb = new Facebook\Facebook([
                              'app_id' => '1020966631330308', // Replace {app-id} with your app id
                              'app_secret' => '82ec1625a31d76812feeeab549b7c8c9',
                              'default_graph_version' => 'v2.2',
                              ]);

                            $helper = $fb->getRedirectLoginHelper();

                            $permissions = ['email']; // Optional permissions
                           $loginUrl = $helper->getLoginUrl('http://imdstagram.wearestrong.be/views/fb-register.php', $permissions);
// $loginUrl = $helper->getLoginUrl('http://localhost:8888/views/fb-register.php', $permissions);

                            echo '<a href="' . htmlspecialchars($loginUrl) . '" class="button"><i class="fa fa-facebook-official" aria-hidden="true"></i>Sign up with Facebook</a>';
                        ?>       
                    
                </div>
                <a href="index.php" class="already-signedup">Already signed up?</a>
			</form>
		</div>
	</body>
</html>