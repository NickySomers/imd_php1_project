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
                header("Location: register-complete.php");
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
                $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
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

                    return true;
                }
                else
                {
                    return false;
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


        public function signUpWithFb(){
            //require_once  '../src/Facebook/autoload.php';
  
              $fb = new Facebook\Facebook([
                'app_id' => '1020966631330308', // Replace {app-id} with your app id
                'app_secret' => '6f73476c36bb5ffb9b12aa99fe57b42a',
                'default_graph_version' => 'v2.2',
                ]);

            $helper = $fb->getRedirectLoginHelper();

            try {

              $accessToken = $helper->getAccessToken();
               $response = $fb->get('/me?fields=id,name,email', $accessToken);

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              // When Graph returns an error
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              // When validation fails or other local issues
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }

            if (! isset($accessToken)) {
              if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
              } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
              }
              exit;
            }

            // The OAuth 2.0 client handler helps us manage access tokens
            $oAuth2Client = $fb->getOAuth2Client();

            // Get the access token metadata from /debug_token
            $tokenMetadata = $oAuth2Client->debugToken($accessToken);

            // Validation (these will throw FacebookSDKException's when they fail)
            $tokenMetadata->validateAppId('1020966631330308'); // Replace {app-id} with your app id
            // If you know the user ID this access token belongs to, you can validate it here
            //$tokenMetadata->validateUserId('123');
            $tokenMetadata->validateExpiration();

            if (! $accessToken->isLongLived()) {
              // Exchanges a short-lived access token for a long-lived one
              try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
              } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
              }
            }

            $_SESSION['fb_access_token'] = (string) $accessToken;

            $user = $response->getGraphUser();

            $output['email'] = $user['email'];

            $name = explode(" ", $user['name']);

            $output['email'] = $user['email'];
            $output['firstname'] = $name[0];
            $output['lastname'] = $name[1];
            
            return $output;
        }


}
?>