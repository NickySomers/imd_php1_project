<?php 

    include_once("../classes/User.class.php");

    if(!empty($_POST))
    {
        try
        {   
            $user = new User();
            $user->FullName = $_POST['full_name'];
            $user->Email = $_POST['register_email'];
            $password = $_POST['register_password'];
            $confirm_password = $_POST['confirm_register_password'];
            $user->Register($password, $confirm_password);
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
                <label for="full_name">Full name</label>
				<input type="text" name="full_name" class="textfield" placeholder="Full name">
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