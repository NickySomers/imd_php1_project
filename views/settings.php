<?php
    
    session_start();
    if(empty($_SESSION['user']))
    {
        header("Location: index.php");
    }

	//Include all classes
	spl_autoload_register(function ($class) {
		include '../classes/' . $class . '.class.php';
	});

    $user = new User(); 
    $user->getDataFromDatabase($_SESSION['user']);

    if(!empty($_POST)){
        $user->changeProfile($_SESSION['user'], $_POST['email']);
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Settings | IMDstagram</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    </head>

    <body>
        <?php include_once("header.php"); ?>

            <div class="wrapper">
                <h1>Settings</h1>


                <form action="" method="post">
                    <h2>Personal data</h2>
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="E-mail" value="<?php echo $user->Email; ?>" class="form-control">

                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $user->Firstname; ?>" class="form-control">

                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" placeholder="Lastname" value="<?php echo $user->Lastname; ?>" class="form-control">
                    
                    <label for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" placeholder="Birthdate" value="<?php echo $user->Birthdate; ?>" class="form-control">
                    
                    <label for="gender">Gender</label>
                    <select name="gender">
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>

                    <label for="description">Description</label>
                    <textarea name="decription" class="form-control" placeholder="Description">
                        <?php echo $user->Description; ?>
                    </textarea>

                    <h2>Contact</h2>
                    <label for="lastname">Website</label>
                    <input type="text" name="website" placeholder="Website" value="<?php echo $user->Website; ?>" class="form-control">

                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" placeholder="Phone number" value="<?php echo $user->Phone; ?>" class="form-control">
                    
                    
                    <h2>Danger zone</h2>
                    <input type="checkbox" name="private"> Private account
                    
                    
                    <button type="button" class="btn btn-danger">Delete account</button>
                    
                    <button type="submit" class="btn btn-primary btn-lg">Update settings</button>
                </form>
            </div>


    </body>

    </html>