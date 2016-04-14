<?php

    class User
	{
		private $m_sFirstname;
        private $m_sLastname;
		private $m_sEmail;
		private $m_sPassword;
        private $m_sConfirm_password;

        // SETTER
        public function __set( $p_sProperty, $p_vValue )
        {
            switch($p_sProperty)
            {
                case 'Firstname':
                    $this->m_sFirstname = $p_vValue;
                break;
                case 'Lastname':
                    $this->m_sLastname = $p_vValue;
                break;
                case 'Email':
                    $this->m_sEmail = $p_vValue;
                break;
                case 'Password':
                    $this->m_sPassword = $p_vValue;
                break;
                case 'ConfirmPassword':
				    $this->m_sConfirm_password = $p_vValue;
				break;
                    
				default: echo("Not existing property: " . $p_sProperty);
            } 
        }

		// GETTER
        public function __get($p_sProperty)
        {
            switch($p_sProperty)
            {
                case 'Firstname':
                    return($this->m_sFirstname);
                break;
                case 'Lastname':
                    return($this->m_sLastname);
                break;
                case 'Email':
                    return($this->m_sEmail);
                break;
                case 'Password':
                    return($this->m_sPassword);
                break;
                case 'ConfirmPassword':
                    return($this->m_sConfirm_password);
                break;
                    
                default: echo("Not existing property: " . $p_sProperty);
            }
        }

		public function register($p_sFirstname, $p_sLastname, $p_sEmail, $p_sPassword, $p_sConfirm_password)
        {
            if(!empty($p_sFirstname) && !empty($p_sLastname) && !empty($p_sEmail) && !empty($p_sPassword) && !empty($p_sConfirm_password) && $p_sPassword == $p_sConfirm_password)
            {
				$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $hashedPw = password_hash($p_sPassword, PASSWORD_DEFAULT);

                $data = $conn->query("INSERT INTO users(firstname, lastname, email, password) VALUES(" . $conn->quote($p_sFirstname) . ", ". $conn->quote($p_sLastname) .",". $conn->quote($p_sEmail) .",". $conn->quote($hashedPw) .")");
                header("Location: index.php");
            } 
            else
            {
                throw new Exception("Please fill in all fields and two correct passwords");
            }
        }


        function CanLogin($username, $password)
        {
            $conn = new mysqli("localhost", "root", "root", "imdstagram");

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