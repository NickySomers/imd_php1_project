<?php
	include_once("User.class.php");
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
					return($this->m_iLikesCount);
				break;
                case 'Filter':
			 		return($this->m_sFilter);
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
            
            $filter = $this->m_sFilter;
            
            $this->addToDatabase($path, $description, $user, $filter);
             
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
        
        
        public function addToDatabase($path, $description, $user, $filter)
        { 
            try 
            {
				$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $data = $conn->query("INSERT INTO posts(picturePath, description, userId, filter) VALUES ('".$path."', '".$description."', '".$user."', '".$filter."')");
			} 
            catch(PDOException $e) 
            {
			    echo 'ERROR: ' . $e->getMessage();
			}   
        }

        public function display(){
        	$user = new User();
        	$user->getDataFromDatabase($this->User);

        	echo '<div class="wrap-photo" data-index="'.$this->Id.'">';
        	echo '<div class="header-photo"><div class="profile-pic" style="background-image: url('.$user->Avatar.');"></div>';
        	echo '<div class="profile-name">'.$user->Username.'</div>';

        	$now = time();
	        $your_date = strtotime($this->Date);
	        $datediff = $now - $your_date;
	        $amount = floor($datediff/(60*60*24));
	        if($amount == 0){
	            $date = "Today";
	        }else{
	            if($amount == 1){
	            	$date = "Yesterday";
	            }else{
	                $date = $amount . " days ago";
	            }
	        } 

	        echo '<div class="minutes-posted">'.$date.'</div></div>';
            echo '<img src="'.$this->Path.'" alt="Photo" width="100%" height="auto">';  
            echo '<div class="footer-photo"><div class="likes"><span class="likesCount">'.$this->LikesCount.'</span> likes</div><div class="wrap-description">';              
            echo '<div class="description-username">'.$user->Username.'</div>';
            $description = "";
            $tagword = "";
            if(!empty($this->Description)){
                 $strlen = strlen($this->Description);
                
                $tag = false;
                for( $i = 0; $i <= $strlen; $i++ ) {
                    $char = substr( $this->Description, $i, 1 );

                    if($char == "#"){
                        $tag = true;
                    }else{
                        if($tag == true){
                            if($char == " " || $char == ""){
                                $description .= ' <a href="search.php?q='.$tagword.'">#'.$tagword.'</a> ';
                                $tagword="";
                                $tag = false;
                            }else{
                                $tagword .= $char;
                            }
                        }else{
                            $description .= $char;
                        }
                    }
                }
            }     
                                
      		echo '<div class="description-text">'.$description.'</div></div><div class="line"></div><div class="wrap-liken">';

      		if($this->Liked == true){
      			echo '<div class="liken liked"></div>';
      		}else{
      			echo '<div class="liken"></div>';
      		}

      		echo '<input type="text" name="comment" class="comment" placeholder="Add a comment..."><div class="dots"></div></div></div></div>';

        }
	
	}

?>