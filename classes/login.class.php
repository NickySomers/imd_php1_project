<?php
class login{
    function CanLogin($username, $password)
    {
        $conn = new mysqli("localhost", "root", "", "imdstagram");

        if (!$conn->connect_errno) {
            $query = "SELECT * FROM users WHERE email = '" . $conn->real_escape_string($username) . "'";
            $result = $conn->query($query);
            $row_hash = $result->fetch_array(/*MYSQLI_ASSOC*/);
            if (password_verify($password, $row_hash['password'])) {
                header('Location: feed.php');
            } else {
                $message = "Username and/or Password incorrect.\\nTry again.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }


        }
    }
}

?>