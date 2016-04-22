<?php
class User
{
	private $m_sFirstname;
	private $m_sLastname;
	private $m_sUsername;
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
			case 'Username':
				$this->m_sUsername = $p_vValue;
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
			case 'Username':
				return($this->m_sUsername);
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
			$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "");
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

	public function canLogin($p_sEmail, $p_sPassword)
	{

		//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (!empty($p_sEmail) && !empty($p_sPassword)/*!$conn->connect_errno*/)
		{
			$conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "");
			//$hashedPw = password_hash($p_sPassword, PASSWORD_DEFAULT);
			//$query = "SELECT * FROM users WHERE email = '" :email "' AND password = '" . $conn->quote($hashedPw) . "' ";

			//$result = $conn->query($query);
			//$row_hash = $result->fetch(PDO::FETCH_ASSOC);

			$query = $conn->prepare('SELECT * FROM users WHERE email = :email');
			$query->bindParam(':email', $p_sEmail);
			$query->execute();
			$result = $query -> fetch(PDO::FETCH_ASSOC);
			//var_dump($result);



			if (password_verify($p_sPassword, $result['password']))
			{
				$_SESSION['user'] = $result['id'];
				header('Location: feed.php');
				$userData= [
					'id' => $result['id'],
					'userName'=> $result['username'],
					'firstName'=> $result['firstname'],
					'lastName'=> $result['lastname'],
					'profilePicture' => $result['profilePicture'],
					'birthdate' => $result['birthdate']
				];
				session_start();
				$_SESSION['loggedIn'] = $userData;





			}
			else
			{
			//	throw new Exception("Invalid password or username.");

				echo 'fout';
			}
		}
	}


	function getDataFromDatabase($id)
	{
		$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$data = $conn->query("SELECT * FROM users WHERE id = '".$id."'");

		foreach ($data as $row) {

			$this->Firstname = $row['firstname'];
			$this->Lastname = $row['lastname'];
			$this->Username = $row['username'];

		}


	}
}
?>