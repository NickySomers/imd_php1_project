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

		public function uploadPhoto()
		{

			if(!empty($_FILES["image"]["tmp_name"])){


				$target_dir = "../public/uploads/";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			    $check = getimagesize($_FILES["image"]["tmp_name"]);

			    if($check !== false) {

			        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				        $_SESSION['feedback'] = "Hooray! Your picture is uploaded.";
				    } 

			    } else {

			        $_SESSION['feedback'] = "There was an error!";

			    }
			}
		
		}
	
	}

?>