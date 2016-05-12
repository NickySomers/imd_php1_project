<nav class="navbar navbar-default navbar-static-top navbar-inverse">
    <div class="wrapper">

        <a class="navbar-brand" href="#">IMDstagram</a>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="feed.php">Feed</a></li>
                <li><a href="upload.php">Upload</a></li>
                <li><a href="profile.php?id=<?php echo $_SESSION['user']; ?>">My account</a></li>
                <li><a href="settings.php">Settings</a></li>

            </ul>
        </div>
    </div>
</nav>