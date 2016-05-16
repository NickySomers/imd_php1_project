<?php
    $current = new User();
    $current->Id = $_SESSION['user'];
    $current->getDataFromDatabase();
?>
<header>
        <a href="index.php">
            <div class="logo-container">
                <div class="logo"></div>
            </div>
        </a>
        <input type="text" name="search" class="input-search" placeholder="Search">
        <div class="user-profile" style="background-image: url(<?php echo $current->Avatar; ?>)"></div>
        <div class="user-profile-options">
            <ul>
                <li><a href="profile.php?id=<?php echo $_SESSION['user']; ?>">My profile <i class="fa fa-user" aria-hidden="true"></i></a></li>
                <li id="notifications">Notifications<i class="fa fa-upload" aria-hidden="true"></i></li>
                <li><a href="upload.php">Upload a photo<i class="fa fa-upload" aria-hidden="true"></i></a></li>
                <li><a href="settings.php">Settings<i class="fa fa-cogs" aria-hidden="true"></i></a></li>
                <li><a href="logout.php">Log out<i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
            </ul>
        </div>

        <div class="search-overlay"></div>

        <div class="wrap-suggestions">
            <div class="wrap-cancel">
                <div class="cancel"><img src="../images/cancel.svg" alt="Cancel"></div>
                <div class="suggestions"></div>
            </div>
        </div>

        <div class="wrap-notifications">
            <div class="wrap-cancel">
                <div class="cancel"><img src="../images/cancel.svg" alt="Cancel"></div>
                <div class="notifications">
                    <div class="search-title">
                        Notifications
                    </div>
                    <?php if($current->checkForNotifications()): ?>

                    <?php for($i = 0; $i < count($current->Notifications); $i++): ?>
                            <div class="notification" data-notificationId="<?php echo $current->Notifications[$i]["id"]; ?>">
                                <p><?php echo $current->Notifications[$i]["text"]; ?></p>
                                <div class="button-group">
                                    <button class="accept button">Accept</button>
                                    <button class="decline button">Decline</button>
                                </div>
                            </div>
                            

                    <?php endfor; endif; ?>
                </div>
            </div>
        </div>

         <!-- JAVASCRIPT AND JQUERY -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="../js/search.js"></script>
        <script src="http://use.fontawesome.com/124768e08b.js"></script>
        <script>
            
            $("#notifications").click(function(){
                $(".wrap-notifications").css("display", "flex");
                $(".user-profile-options").toggle();
                $(".search-overlay").fadeIn();
            });


            function checkNotifications(){

                var count = $(".notification").length;

                if(count <= 0){
                    $(".notifications").append("<p class='noposts-feedback'>You have no new notifications at this moment.</p>");
                }

            }

            checkNotifications();

            $(".accept").click(function(){
                var btn = $(this);
                var data = {
                    id: btn.closest(".notification").attr("data-notificationId")
                }
                $.post("../ajax/acceptNotification.php", data, function(res) {

                    btn.closest(".notification").remove();
                    checkNotifications();
                });

            });

            $(".decline").click(function(){
                var btn = $(this);
                var data = {
                    id: btn.closest(".notification").attr("data-notificationId")
                }
                $.post("../ajax/declineNotification.php", data, function(res) {

                    btn.closest(".notification").remove();
                    checkNotifications();
                });

            });




        </script>

</header>
<?php
    if(!empty($_SESSION['feedback']))
    {
        echo '<div class="feedback"><div class="wrapper">'.$_SESSION['feedback'].'</div></div>';
        unset($_SESSION['feedback']);
    }
?>