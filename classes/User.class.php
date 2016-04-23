<?php

    class User
	{
        private $m_iId;
		private $m_sFirstname;
        private $m_sLastname;
        private $m_sUsername;
		private $m_sEmail;
		private $m_sPassword;
		private $m_sDescription;
		private $m_sWebsite;
		private $m_sPhone;
		private $m_bPrivate;
		private $m_sBirthdate;
		private $m_bGender;
        private $m_aErrors;
        

        // SETTER
        public function __set( $p_sProperty, $p_vValue )
        {
            switch($p_sProperty)
            {
                case 'Id':
                    $this->m_iId = $p_vValue;
                break;
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
                case 'Birthdate':
                    $this->m_sBirthdate = $p_vValue;
                break;
                case 'Password':
                    $this->m_sPassword = $p_vValue;
                break;         
                case 'Description':
                    $this->m_sDescription = $p_vValue;
                break;
                case 'Website':
                    $this->m_sWebsite = $p_vValue;
                break;
                case 'Phone':
                    $this->m_sPhone = $p_vValue;
                break;
                case 'Private':
                    $this->m_bPrivate = $p_vValue;
                break;    
                case 'Gender':
                    $this->m_bGender = trim($p_vValue);
                break;
                case 'Errors':
                    $this->m_aErrors[] = $p_vValue;
                break;
     
				default: echo("Not existing property: " . $p_sProperty);
            } 
        }

		// GETTER
        public function __get($p_sProperty)
        {
            switch($p_sProperty)
            {
                case 'Id':
                    return($this->m_iId);
                break;
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
                case 'Description':
                    return($this->m_sDescription);
                break;
                case 'Password':
                    return($this->m_sPassword);
                break;
                case 'Website':
                    return($this->m_sWebsite);
                break;
                case 'Phone':
                    return($this->m_sPhone);
                break;
                case 'Private':
                    return($this->m_bPrivate);
                break;
                case 'Birthdate':
                    return($this->m_sBirthdate);
                break;
                case 'Gender':
                    return($this->m_bGender);
                break;
                case 'Errors':
                    return($this->m_aErrors);
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


        //TODO: Change mysqli to PDO because it's safer.
        function canLogin($username, $password)
        {
            $conn = new mysqli("localhost", "root", "root", "imdstagram");

            if (!$conn->connect_errno) {
                $query = "SELECT * FROM users WHERE email = '" . $conn->real_escape_string($username) . "'";
                $result = $conn->query($query);
                $row_hash = $result->fetch_array();
                if (password_verify($password, $row_hash['password'])) {
                    $_SESSION['user'] = $row_hash['id'];
                    
                    header('Location: feed.php');
                } else {
                    $message = "Username and/or Password incorrect.\\nTry again.";
                    
                    //TODO:  Change this because an alert is a not done!
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }


            }
        }
        
        function getDataFromDatabase($id)
        {
            $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $conn->query("SELECT * FROM users WHERE id = '".$id."'"); 
            
            foreach ($data as $row) {
                
                $this->Id = $row['id'];
                $this->Firstname = $row['firstname'];
                $this->Lastname = $row['lastname'];
                $this->Username = $row['username'];
                $this->Email = $row['email'];
                $this->Description = $row['description'];
                $this->Website = $row['website'];
                $this->Gender = $row['gender'];
                $this->Phone = $row['phone'];
                $this->Private = $row['privateAccount'];
                $this->Birthdate = $row['birthdate'];
                
            } 
        }

        public function checkInDatabase($column, $data){
            $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $conn->query("SELECT ".$column." FROM users"); 

            $result = $data->fetch(PDO::FETCH_NUM);

            if(in_array($data, $result)){
                return false;
            }else{
                return true;
            }
        }

        // Show errors in a HTML list
        public function showFeedback(){

            if(count($this->Errors) > 0){
                $output = '<div class="alert alert-danger" role="alert"><p>There were some errors while changing your account information:</p><ul>';

                for($i = 0; $i < count($this->Errors); $i++){
                    $output .= "<li>".$this->Errors[$i]."</li>";
                }

                $output .= "</ul></div>";

                
            }else{
                
                $output = '<div class="alert alert-success" role="alert">Your changes are successfully saved.</div>';

            }

            return $output;

        }
        
        
        public function changeProfile($user, $email, $firstname, $lastname, $username, $website, $phone, $private, $birthdate_day, $birthdate_month, $birthdate_year, $gender, $description, $picture)
        {
            if($this->Email !== $email){
                if(!empty($email)){
                    if($this->checkInDatabase("email", $email)){
                        $this->Email = $email;
                    }else{
                        $this->Errors = "Undefined error";
                    }
                }else{
                    $this->Errors = "Please fill in your email.";
                }
            }

            if(empty($firstname)){
                $this->Errors = "Please fill in your firstname.";
            }else{
                $this->Firstname = $firstname;
            }

            if(empty($lastname)){
                $this->Errors = "Please fill in your lastname.";
            }else{
                $this->Lastname = $lastname;
            }

            if($username !== $this->Username){
                if(empty($username)){
                    $this->Errors = "Please fill in your username.";
                }else{
                    if(!$this->checkInDatabase("username", $username)){
                        if(strlen($username) < 4){
                            $this->Errors = "Your username must be at least 4 characters long.";
                        }else{
                            $this->Username = $username;
                        }
                    }else{
                        //TODO: REALTIME CHECK WITH AJAX
                        $this->Errors = "The username '".$username."' is already taken.";
                    }
                }
            }
            
            $this->Website = $website;
            $this->Phone = $phone;

            if($private == "on"){
                $this->Private = 1;
            }else{
                $this->Private = 0;
            }
      
            $birthdate = $birthdate_year . "-" . $birthdate_month . "-" . $birthdate_day;
            
            $this->Birthdate = $birthdate;

            $this->Gender = $gender;
            $this->Description = $description;
            

            if(!empty($picture)){
                $profilePicturePath = "../public/users/" . $this->Id . ".png";

                if ($picture["size"] > 500000) {
                    $this->Errors = "The size of your profile picture is too big. The maximum file size is 50MB.";
                }else{
                    //TODO: MODIFY IF SO THERE IS NO EMPTY IF STATEMENT
                    if (move_uploaded_file($picture["tmp_name"], $profilePicturePath)) {

                    } 
                }
            }


            if(count($this->Errors) == 0){

                //TODO: Change query to $this->PROPERTY
                $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $data = $conn->query("UPDATE users SET email='".$email."',  firstname='".$firstname."', lastname='".$lastname."', username='".$username."', website='".$website."', phone='".$phone."', privateAccount='".$this->Private."', birthdate='". $birthdate."', gender='".$gender."', description='".$description."', profilePicture='".$profilePicturePath."' WHERE id='".$user."'"); 
            
            } 
        }

        public function deleteAccount(){

            $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
            
            $statement = $conn->prepare("DELETE FROM users WHERE id = ?");
            $statement->execute(array($this->Id));
            session_destroy();
            header("Location: index.php");
        }




    }

?>