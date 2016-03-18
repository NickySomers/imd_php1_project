<!DOCTYPE html>
<html>
	<head>
		<title>IMDstagram</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body class="home">
		<div class="overlay"></div>
		<div class="login">
			<h1 class="logo">IMDstagram</h1>
			<form action="" method="post">
				<label for="email">E-mail</label>
				<input type="text" name="login_email" class="textfield">
				<label for="password">Password</label>
				<input type="password" name="login_password" class="textfield">
				<input type="submit" class="button" value="Log in">
			</form>
			<div class="grid">
				<div class="col">
					<a href="views/register.php">Sign up</a>
				</div>
				<div class="col">
					<a href="views/lost_password.php">Lost password?</a>
				</div>
			</div>	
		</div>
	</body>
</html>