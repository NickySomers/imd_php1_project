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
    $user->Id = $_SESSION['user'];
    $user->getDataFromDatabase();

    if(!empty($_POST)){

        if(!isset($_POST['private'])){
            $_POST['private'] = null;
        }

        $user->changeProfile($_SESSION['user'], $_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['website'], $_POST['phone'], $_POST['private'], $_POST['birthdate_day'], $_POST['birthdate_month'], $_POST['birthdate_year'], $_POST['gender'], $_POST['description'], $_FILES['profilePicture'], $_FILES['header'], $_POST['password'], $_POST['password_confirm']);
    }

    if(!empty($_GET)){
        $user->deleteAccount();
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

                <div class="alert alert-warning save-warning" role="alert">
                    You have unsaved changes. Be sure to save this form before leaving.
                </div>
                <?php if(!empty($_POST) && $user->showFeedback()): ?>
                    <?php echo $user->showFeedback(); ?>
                <?php endif; ?>
    
                <form action="" method="post" enctype="multipart/form-data">
                    <h2>Personal data</h2>
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="E-mail" value="<?php echo $user->Email; ?>" class="form-control">

                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $user->Firstname; ?>" class="form-control">

                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" placeholder="Lastname" value="<?php echo $user->Lastname; ?>" class="form-control">
                    
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $user->Username; ?>" class="form-control">
                    
                   
                    <?php $date = explode("-", $user->Birthdate); ?>
                    
                    <label for="birthdate">Birthdate</label>
                    <label for="birthdate_day">Day</label>
                    <select name="birthdate_day">
                        <?php for($i = 1; $i <= 31; $i++): ?>
                            <?php 
                                $selected = null;
                                if($date[2] == $i)
                                {
                                    $selected = 'selected';
                                }
                            ?>
                            <?php if($i < 10): ?>
                                <option value="<?php echo $i; ?>" <?php echo $selected; ?>>0<?php echo $i; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>

                    <label for="birthdate_month">Month</label>
                    <select name="birthdate_month">
                        <?php for($i = 1; $i <= 12; $i++): ?>
                           <?php 
                                $selected = null;
                                if($date[1] == $i)
                                {
                                    $selected = 'selected';
                                }
                            ?>
                            <?php if($i < 10): ?>
                                <option value="<?php echo $i; ?>" <?php echo $selected; ?>>0<?php echo $i; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>

                    <label for="birthdate_year">Year</label>
                    <select name="birthdate_year">
                        <?php for($i = 2000; $i >= 1900; $i--): ?>
                            <?php 
                                $selected = null;
                                if($date[0] == $i)
                                {
                                    $selected = 'selected';
                                }
                            ?>
                            <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>  
                        <?php endfor; ?>
                    </select>

                    <br>
                    
                    <label for="gender">Gender</label>
                    <select name="gender">
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>

                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" placeholder="Description"><?php echo trim($user->Description); ?></textarea>
                    
                    <img src="../public/users/<?php echo $user->Id; ?>.png" class="profile-picture">
                    <label for="profilePicture">Profile picture</label>
                    <input type="file" name="profilePicture" id="profilePicture">

                    <label for="header">Header</label>
                    <input type="file" name="header" id="header">

                    <h2>Contact</h2>
                    <label for="lastname">Website</label>
                    <input type="text" name="website" placeholder="Website" value="<?php echo $user->Website; ?>" class="form-control">

                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" placeholder="Phone number" value="<?php echo $user->Phone; ?>" class="form-control">
                    
                    <h2>Change password</h2>
                    <label for="lastname">New password</label>
                    <input type="text" name="password" placeholder="Password" class="form-control">

                    <label for="phone">Comfirm new password</label>
                    <input type="text" name="password_confirm" placeholder="Confirm password" class="form-control">

                    <h2>Danger zone</h2>

                    <?php if($user->Private): ?>
                        <input type="checkbox" name="private" checked> Private account
                    <?php else: ?>
                        <input type="checkbox" name="private"> Private account
                    <?php endif; ?>
                    
                    
                    
                    <button type="button" id="deleteAccount" class="btn btn-danger">Delete account</button>
                    
                    <button type="submit" class="btn btn-primary btn-lg">Update settings</button>
                </form>

                <form action="" method="get" class="deleteAccountForm">
                    <input type="text" value="DELETING ACCOUNT" name="deleteAccount" hidden>
                    <input type="submit" class="btn btn-danger" value="DELETE ACCOUNT NOW">
                </form>
            </div>
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script>
            $(".save-warning").hide();
            $('input').change(function(){

                $(".save-warning").fadeIn();

            });

            $(".deleteAccountForm").hide();
            $("#deleteAccount").click(function(){
                $(".deleteAccountForm").fadeIn();
            });
        </script>


    </body>

    </html>