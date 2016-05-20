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

    <body class="settings">
        <?php include_once("header.php"); ?>

        <div class="settings-menu">
            <ul>
                <li class="open-account-settings"><i class="fa fa-user" aria-hidden="true"></i> Account information</li>
                <li class="open-contact-settings"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact information</li>
                <li class="open-password-settings"><i class="fa fa-key" aria-hidden="true"></i> Change password</li>
                <li class="open-privacy-settings"><i class="fa fa-lock" aria-hidden="true"></i> Privacy settings</li>
                <li class="open-delete"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Delete accounts</li>
            </ul>
        </div>

        <div class="content">





                <div class="alert alert-warning save-warning" role="alert">
                    You have unsaved changes. Be sure to save this form before leaving.
                </div>
                <?php if(!empty($_POST) && $user->showFeedback()): ?>
                    <?php echo $user->showFeedback(); ?>
                <?php endif; ?>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="account-settings page">
                        <h2>Personal data</h2>
                        <label for="email">E-mail</label>
                        <input type="text" name="email" placeholder="E-mail" value="<?php echo $user->Email; ?>" class="textfield">

                        <label for="firstname">Firstname</label>
                        <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $user->Firstname; ?>" class="textfield">

                        <label for="lastname">Lastname</label>
                        <input type="text" name="lastname" placeholder="Lastname" value="<?php echo $user->Lastname; ?>" class="textfield">
                        
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="Username" value="<?php echo $user->Username; ?>" class="textfield">
                        
                       
                        <?php $date = explode("-", $user->Birthdate); ?>
                        
                        <label for="birthdate">Birthdate</label>
                        <div class="birthdate">
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

                        </div>
                        
                        <label for="gender">Gender</label>
                        <select name="gender">
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select>

                        <label for="description">Description</label>
                        <textarea name="description" class="textarea" placeholder="Description"><?php echo trim($user->Description); ?></textarea>
                        <h3>Profile picture</h3>
                        <img src="../public/users/<?php echo $user->Id; ?>.png" class="profile-picture">
                        <label for="profilePicture" class="button upload">Choose file</label>
                        <input type="file" name="profilePicture" id="profilePicture">
                        <h3>Header</h3>
                        <label for="header" class="button">Choose file</label>
                        <input type="file" name="header" id="header">
                    </div>
                    <div class="contact-settings page">
                        <h2>Contact</h2>
                        <label for="lastname">Website</label>
                        <input type="text" name="website" placeholder="Website" value="<?php echo $user->Website; ?>" class="textfield">

                        <label for="phone">Phone number</label>
                        <input type="text" name="phone" placeholder="Phone number" value="<?php echo $user->Phone; ?>" class="textfield">
                    </div>
                    <div class="password-settings page">
                        <h2>Change password</h2>
                        <label for="password">New password</label>
                        <input type="password" name="password" placeholder="Password" class="textfield">

                        <label for="password_confirm">Comfirm new password</label>
                        <input type="password" name="password_confirm" placeholder="Confirm password" class="textfield">
                    </div>

                    <div class="privacy-settings page">
                        <h2>Danger zone</h2>

                        <?php if($user->Private): ?>
                            <input type="checkbox" name="private" checked> <span>Private account</span>
                        <?php else: ?>
                            <input type="checkbox" name="private"> <span>Private account</span>
                        <?php endif; ?>
                    
                    </div>
                    <div class="delete-account-settings page">
                        <button type="button" id="deleteAccount" class="button">Delete account</button>
                    </div>
                    
                    
                    <button type="submit" class="button save">Save settings</button>
                </form>

                <form action="" method="get" class="deleteAccountForm">
                    <input type="text" value="DELETING ACCOUNT" name="deleteAccount" hidden>
                    <input type="submit" class="btn btn-danger" value="DELETE ACCOUNT NOW">
                </form>
            </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="../js/script.js"></script>
        <script>
            $(".save-warning").hide();
            $('input').change(function(){

                $(".save-warning").fadeIn();

            });

            $(".deleteAccountForm").hide();
            $("#deleteAccount").click(function(){
                $(".deleteAccountForm").fadeIn();
            });

            $(".open-password-settings").click(function(){
                $(".page").hide();
                $(".save").show();
                $(".password-settings").show();
            });

             $(".open-contact-settings").click(function(){
                $(".page").hide();
                $(".save").show();
                $(".contact-settings").show();
            });

             $(".open-account-settings").click(function(){
                $(".page").hide();
                $(".save").show();
                $(".account-settings").show();
            });

              $(".open-privacy-settings").click(function(){
                $(".page").hide();
                $(".save").show();
                $(".privacy-settings").show();
            });

             $(".open-delete").click(function(){
                $(".page").hide();
                $(".save").hide();
                $(".delete-account-settings").show();
            });
        </script>


    </body>

    </html>