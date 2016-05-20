<?php
    spl_autoload_register(function ($class) {
        include_once '../classes/' . $class . '.class.php';
    }); 

	class Comment
	{
		private $m_sText;
		private $m_iUser;
		private $m_iPost;

		public function __set( $p_sProperty, $p_vValue )
	    {
	        switch($p_sProperty)
			{
				case 'Text':
			 		$this->m_sText = $p_vValue;
				break;
				case 'User':
			 		$this->m_iUser = $p_vValue;
				break;
				case 'Post':
			 		$this->m_iUser = $p_vValue;
				break;
			}
		}

		public function __get($p_sProperty)
		{
			switch($p_sProperty)
			{
				case 'Text':
					return($this->m_sText);
				break;
				case 'User':
					return($this->m_iUser);
				break;
				case 'Post':
					return($this->m_iUser);
				break;
			}
		}

		public function add(){

			$db = new Db();
			$conn = $db->connect();

			$query = $conn->query("INSERT INTO posts_comments(comment, postId, userId) VALUES('".$this->Text."','".$this->User."','".$this->Post."')");

		}


	}

?>