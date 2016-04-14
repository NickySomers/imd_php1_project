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
				if(!empty($_POST['full_name']))
				{
					$this->m_sFull_name = $p_vValue;
				}
				break;
			case 'Email':
				if(!empty($_POST['register_email']))
				{
					$this->m_sEmail = $p_vValue;
				}
				break;
			case 'Password':
				if(!empty($_POST['register_password']) && !empty($_POST['confirm_register_password']))
				{
					$this->m_sPassword = $p_vValue;
				}
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
		if(!empty($this->m_sFull_name) && !empty($this->m_sEmail) && !empty($password) && !empty($confirm_password))
		{
			// connectie
			$connection = new mysqli("localhost", "root", "", "IMDstagram");
			if($connection->connect_errno)
			{
				die("No database connection");
			}
			$options = [
				'cost' => 12,
			];
			if($password == $confirm_password)
			{
				$this->Password = password_hash($password, PASSWORD_DEFAULT, $options);

				// query
				$query = "INSERT INTO users(full_name, email, password) VALUES ('$this->FullName', '$this->Email', '$this->Password');";
				if($connection->query($query))
				{
					header("Location: index.php");
				}
			}
			else
			{
				throw new Exception("Please fill in two identical passwords");
			}
		}
		else
		{
			throw new Exception("Please fill in all fields");
		}
	}
}
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