<?php

	class Photo
	{

		private $m_sName;
		private $m_iUser;
		private $m_sDescription;
		private $m_sPath;

		public function __set( $p_sProperty, $p_vValue )
	    {
	        switch($p_sProperty)
			{
				case 'Name':
			 		$this->m_sName = $p_vValue;
				break;
				case 'User':
			 		$this->m_iUser = $p_vValue;
				break;
				case 'Description':
			 		$this->m_sDescription = $p_vValue;
				break;
				case 'Path':
			 		$this->m_sPath = $p_vValue;
				break;
			} 
	    }

	    public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Name':
					return($this->m_sName);
				break;
				case 'User':
					return($this->m_iUser);
				break;
				case 'Description':
					return($this->m_sDescription);
				break;
				case 'Path':
					return($this->m_sPath);
				break;
			}
		} 

		public function upload($description, $user)
		{
            
            //TODO: Change this to a javascript alternative

            $img = $_REQUEST['image'];
            preg_match('~data:(.*?);~', $img, $output);

            $extension = explode("/", $output[1]);

            $img = str_replace('data:'.$output[1].';base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            
            $date = date("c");
            
            $path = "../public/uploads/".$date."." . $extension[1];
            
            $success = file_put_contents($path, $data);
            
            $this->addToDatabase($path, $description, $user);
             
            $_SESSION['feedback'] = "Hooray! Your photo is uploaded.";
            
        }
        
        
        public function showPhoto()
        {
            
            if(!empty($_FILES["image"]["tmp_name"])){


				$target_dir = "../public/uploads/";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			    $check = getimagesize($_FILES["image"]["tmp_name"]);

			    if($check !== false) {
                    
                    return "data:" . $check['mime'] . ";base64," . base64_encode(file_get_contents($_FILES["image"]["tmp_name"]));
                    

			     }else{
                    $_SESSION['feedback'] = "Test";
                }
            }
             
        }
        
        
        public function addToDatabase($path, $description, $user){
            
            try {
              
				$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $data = $conn->query("INSERT INTO posts(picturePath, description, userId) VALUES ('".$path."', '".$description."', '".$user."')");

			} catch(PDOException $e) {
			    echo 'ERROR: ' . $e->getMessage();
			}
            
        }
	
	}

?>