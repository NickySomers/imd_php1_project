<?php
	include_once("User.class.php");
	include_once("Db.class.php");

	class Photo
	{
		private $m_iId;
		private $m_sName;
		private $m_iUser;
		private $m_sDescription;
		private $m_sPath;
		private $m_sDate;
		private $m_bLiked;
		private $m_iLikesCount;
		private $m_sLocation;
        private $m_sFilter;


		public function __set( $p_sProperty, $p_vValue )
	    {
	        switch($p_sProperty)
			{
				case 'Id':
			 		$this->m_iId = $p_vValue;
				break;
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
				case 'Date':
			 		$this->m_sDate = $p_vValue;
				break;
				case 'Liked':
			 		$this->m_bLiked = $p_vValue;
				break;
				case 'LikesCount':
			 		$this->m_iLikesCount = $p_vValue;
				break;
				case 'Location':
			 		$this->m_sLocation = $p_vValue;
			 	break;
                case 'Filter':
			 		$this->m_sFilter = $p_vValue;
				break;
			} 
	    }

	    public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Id':
					return($this->m_iId);
				break;
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
				case 'Date':
					return($this->m_sDate);
				break;
				case 'Liked':
					return($this->m_bLiked);
				break;
				case 'LikesCount':
					$db = new Db();
					$conn = $db->connect();
					$allLikes = $conn->query("SELECT * FROM posts_likes WHERE postId = '".$this->Id."'" );
					return($allLikes->rowCount());
				break;
				case 'Location':
					return($this->m_sLocation);
				break;
                case 'Filter':
			 		return($this->m_sFilter);
				break;
			}
		} 

		public function upload($description, $user, $data)
		{
            
            //TODO: Change this to a javascript alternative

            // $img = $_REQUEST['image'];
            // preg_match('~data:(.*?);~', $img, $output);

            // $extension = explode("/", $output[1]);

            // $img = str_replace('data:'.$output[1].';base64,', '', $img);
            // $img = str_replace(' ', '+', $img);
            // $data = base64_decode($img);
            	$target_dir = "../public/uploads/" . $user . "/";
				$target_file = $target_dir . basename($data["name"]);
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			    $check = getimagesize($data["tmp_name"]);

			if($check !== false) {
                date_default_timezone_set("UTC"); 

	            $date = date("c");
	            $dir = "../public/uploads/". $user . "/";
	            $path = "../public/uploads/". $user . "/". time() .".".$imageFileType;
	            
	            if ( ! is_dir($dir)) {
				    mkdir($dir);
				}

	            $success = move_uploaded_file($data["tmp_name"], $path);
	            
	            $filter = $this->m_sFilter;
	            
	            $this->addToDatabase($path, $description, $user, $filter);
	             
	            $_SESSION['feedback'] = "Hooray! Your photo is uploaded.";
	            header("Location: feed.php");

	        }
            
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
            
            $db = new Db();
        	$conn = $db->connect();

        	
        	$description = htmlspecialchars($description);
        	$strlen = strlen($description);
                $output = "";
                $tag = false;
                for( $i = 0; $i <= $strlen; $i++ ) {
                    $char = substr( $description, $i, 1 );

                    if($char == "#"){
                        $tag = true;
                        $tagname = "";
                    }else{
                        if($tag == true){

                            if($char == " " || $char == ""){

                            	$check = $conn->query("SELECT * FROM posts_tags WHERE tag = '".$tagname."'");
                            	if($check->rowCount() == 0){
                            		$conn->query("INSERT INTO posts_tags(tag) VALUES ('".$tagname."')");
                            	}

                                $tag = false;
                                $tagname = "";

                            }else{
                                $tagname .= $char;
                            }
                        }else{
                            $output .= $char;
                        }
                    }
                }




			$data = $conn->query("INSERT INTO posts(picturePath, description, userId, location, filter) VALUES ('".$path."', '".$description."', '".$user."', '".$this->Location."', '".$this->Filter."')");

        }

        public function getDataFromDatabase()
        {
			$db = new Db();
        	$conn = $db->connect();
			$query = $conn->query("SELECT * FROM posts WHERE id = " . $this->Id );
			
			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$this->Path = $row['picturePath'];
				$this->User = $row['userId'];
				$this->Filter = $row['filter'];

                $strlen = strlen($row['description']);
                $description = "";
                $tag = false;
                for( $i = 0; $i <= $strlen; $i++ ) {
                    $char = substr( $row['description'], $i, 1 );

                    if($char == "#"){
                        $tag = true;
                        $tagname = "";
                    }else{
                        if($tag == true){

                            if($char == " " || $char == ""){
                                $description .= '<a href="search.php?q='.$tagname.'">#'.$tagname.'</a>';
                                $tag = false;
                                $tagname = "";

                            }else{
                                $tagname .= $char;
                            }
                        }else{
                            $description .= $char;
                        }
                    }
                }

                $this->Description = $description;

			}
        }

        public function getComments()
        {
        	$db = new Db();
        	$conn = $db->connect();
			$query = $conn->query("SELECT * FROM posts_comments WHERE postId = " . $this->Id );
			$data = $query->fetch(PDO::FETCH_ASSOC);

			return $data;
        }
	
	}

?>