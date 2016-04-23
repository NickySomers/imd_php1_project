
<?php 

    session_start();

    include_once("../classes/User.class.php");

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
				<input type="text" name="firstname" class="textfield" placeholder="First name">
                <label for="lastname">Last name</label>
				<input type="text" name="lastname" class="textfield" placeholder="Last name">
				<label for="register_email">E-mail</label>
				<input type="text" name="register_email" class="textfield" placeholder="E-mail">
				<label for="register_password">Password</label>
				<input type="password" name="register_password" class="textfield" placeholder="Password">
                <label for="confirm_register_password">Confirm password</label>
				<input type="password" name="confirm_register_password" class="textfield" placeholder="Confirm password">
				<input type="submit" class="button" value="Register">
			</form>
		</div>
	</body>
</html>