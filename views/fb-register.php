<?php
include_once('../php/facebook/src/Facebook/autoload.php');
include_once('../classes/Db.class.php');
include_once('../classes/User.class.php');

session_start();

$fb = new Facebook\Facebook([
  'app_id' => '1020966631330308', // Replace {app-id} with your app id
  'app_secret' => '82ec1625a31d76812feeeab549b7c8c9',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
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

	$response = $fb->get('/me?fields=id,name,email,picture,first_name,last_name', $_SESSION['fb_access_token']);
	$user = $response->getGraphUser();


	$db = new Db();
	$conn = $db->connect();
	$error = false;
	$error_log = array();

	$fb = $user['id'];

	$newUser = new User();
	if($newUser->checkEmail()){
		$newUser->Email = $user["email"];
	}else{
		$error_log[] = "E-mail is already in use.";
		$error = true;
	}
	
	$newUser->Firstname = $user["first_name"];
	$newUser->Lastname = $user["last_name"];
	$newUser->Username = strtolower($newUser->Firstname.$newUser->Lastname);

	$avatar = $user["picture"]["url"];

	$newUser->Avatar = $avatar;
	
	// if($error == true){
	// 	$_SESSION['feedback'] = $error_log;
	// 	header("Location register.php");
	// }else{
		$conn->query("INSERT INTO users(email, firstname, lastname, username, profilePicture, fb) VALUES('".$newUser->Email."','".$newUser->Firstname."','".$newUser->Lastname."','".$newUser->Username."','".$newUser->Avatar."', '".$fb."')");

		$getUser = $conn->query("SELECT * FROM users WHERE fb = " . $fb);

		$addedId = $getUser->fetch(PDO::FETCH_NUM);

		$_SESSION['user'] = $addedId[0];
		header("Location: feed.php");
	// }

?>