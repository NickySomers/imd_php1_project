<?php

	include_once('../classes/Photo.class.php');
	include_once('../classes/User.class.php');

	$photo = new Photo();
	$photo->Id = $_POST['id'];
	$photo->getDataFromDatabase();

	$data[] = array();
	$data['path'] = $photo->Path;

	$user = new User();
	$user->Id = $photo->User;
	$user->getDataFromDatabase();

	$data['username'] = $user->Username;
	$data['description'] = $photo->Description;
	$data['likes'] = $photo->LikesCount;

	echo json_encode($data);

?>