<nav class="navbar navbar-default navbar-static-top navbar-inverse">
   
    <div class="container">
        <a class="navbar-brand" href="#">IMDstagram</a>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="feed.php">Feed</a></li>
                <li><a href="upload.php">Upload</a></li>
                <li><a href="profile.php?id=<?php echo $_SESSION['user']; ?>">My account</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
            <input type="text" name="search" class="input-search" placeholder="Search">
            <div class="wrap-suggestions">
                <div class="wrap-cancel">
                    <div class="cancel"><img src="../images/cancel.svg" alt="Cancel"></div>
                    <div class="suggestions"></div>
                </div>
            </div>
        </div>
    </div>

     <!-- JAVASCRIPT AND JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="../js/search.js"></script>
    
</nav>