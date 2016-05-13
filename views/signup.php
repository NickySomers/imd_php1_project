<?php

if(!empty($_POST)){
    $email = $_POST['login_email'];
    $options = $options = [
        'cost' => 12
    ];
    if($_POST['login_password'] == $_POST['login_password_check']){
        $password = password_hash($_POST['login_password'] , PASSWORD_DEFAULT , $options);
        echo $password ;
    }else{
        echo"verkeerd";
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
        <label for="email">E-mail</label>
        <input type="text" name="login_email" class="textfield" placeholder="E-mail">
        <label for="password">Password</label>
        <input type="password" name="login_password" class="textfield" placeholder="Password">
        <label for="password">Repeat password</label>
        <input type="password" name="login_password_check" class="textfield" placeholder="Password">

        <input type="submit" class="button" value="Log in">
    </form>

</div>
</body>
</html>