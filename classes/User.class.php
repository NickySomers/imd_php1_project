<?php

	class User
	{
		private $m_sFull_name;
		private $m_sEmail;
		private $m_sPassword;
        private $m_sConfirm_password;

        public function __set( $p_sProperty, $p_vValue )
        {
            switch($p_sProperty)
            {
                case 'FullName':
                    $this->m_sFull_name = $p_vValue;
                break;
                case 'Email':
                    $this->m_sEmail = $p_vValue;
                break;
                case 'Password':
                    $this->m_sPassword = $p_vValue;
                break;
            } 
        }

        public function __get($p_sProperty)
        {
            switch($p_sProperty)
            {
                case 'FullName':
                    return($this->m_sFull_name);
                break;
                case 'Email':
                    return($this->m_sEmail);
                break;
                case 'Password':
                    return($this->m_sPassword);
                break;
            }
        } 

        function Register($password, $confirm_password)
        {
            // connectie
            $connection = new mysqli("localhost", "root", "root", "IMDstagram");
            if($connection -> connect_errno)
            {
                die("No database connection");
            }
            
            $options = [
                'cost' => 12,    
            ];
            
            if($password == $confirm_password)
            {
                $this->Password = password_hash($password, PASSWORD_DEFAULT, $options);
            }

            // query
            $query = "INSERT INTO users(full_name, email, password) VALUES ('$this->FullName', '$this->Email', '$this->Password');";

            if($connection -> query($query))
            {
                header("Location: index.php");
            }
        }   
    }

?>