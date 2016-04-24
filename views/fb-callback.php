<?php
session_start();
  require_once  '../src/Facebook/autoload.php';
  
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

$conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "root");
$query = $conn->prepare('SELECT email FROM users WHERE email = :email');
$query->bindParam(':email', $email);
$query->execute();
$result = $query -> fetch(PDO::FETCH_ASSOC);

if(count($result)  == 1){
  header('Location: feed.php');
}else{
  echo "ERROR!";
}

?>