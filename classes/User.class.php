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
                    
                case "Firstname":
                    if(!empty($p_vValue))
                    {
                        $this->m_sFirstname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Firstname cannot be empty");
                    }
                break;
                case 'Lastname':
                    if(!empty($p_vValue))
                    {
                        $this->m_sLastname = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Lastname cannot be empty");
                    }
                    $this->m_sLastname = $p_vValue;
                break;
                case 'Email':
                    if(!empty($p_vValue))
                    {
                        $this->m_sEmail = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Email cannot be empty");
                    }
                break;
                case 'Password':
                    if(!empty($p_vValue))
                    {
                        $this->m_sPassword = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Password cannot be empty");
                    }
                break;
                case 'ConfirmPassword':
                    if(!empty($p_vValue))
                    {
                        $this->m_sConfirm_password = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Confirm password cannot be empty");
                    }
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

		public function register()
        {
            if($this->m_sPassword != $this->m_sConfirm_password || !$this->checkEmail())
            {
                throw new Exception("Please fill in all fields and two correct passwords");
            } 
            else
            {
                $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $hashedPw = password_hash($this->m_sPassword, PASSWORD_DEFAULT);

                $data = $conn->query("INSERT INTO users(firstname, lastname, email, password) VALUES(" . $conn->quote($this->m_sFirstname) . ", ". $conn->quote($this->m_sLastname) .",". $conn->quote($this->m_sEmail) .",". $conn->quote($hashedPw) .")");
                header("Location: index.php");
            }
		}
        
        function checkEmail()
        {
            $email = $this->m_sEmail;
            
            $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $query = $conn->query("SELECT email FROM users WHERE email = '". $email ."'");
                
            $count = $query->rowCount();
        
            if($count == 0)
            {
                return true;
            }
            else
            {
                throw new Exception("The email you entered is already in use");
                return false;
            }
        }
	}

?>