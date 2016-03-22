<?php

	class User
	{
		private $m_sFull_name;
		private $m_sEmail;
		private $m_sPassword;
        private $m_sConfirm_password;
	}

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
            case 'ConfirmPassword':
                $this->m_sConfirm_password = $p_vValue;
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
            case 'ConfirmPassword':
                return($this->m_sConfirm_password);
            break;
        }
    } 

    function Register()
    {
        $options = $options = [
            'cost' => 12,    
        ];

        // connectie
        $connection = new mysqli("localhost", "root", "root", "IMDstagram");
        if($connection -> connect_errno)
        {
            die("No database connection");
        }

        // query
        $query = "INSERT INTO users(full_name, email, password, confirm_password) VALUES ('$full_name', '$email', '$password', '$confirm_password');";

        if($connection -> query($query))
        {
            $success = "Welcome to IMDstagram!";
        }
        
    }

?>