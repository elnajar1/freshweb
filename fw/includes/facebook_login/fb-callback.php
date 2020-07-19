<?php
	require_once "config.php";

	try {
		$accessToken = $helper->getAccessToken( "https://freshweb.ml/fw/facebook_login/fb-callback.php" );
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}

	if (!$accessToken) {
		header('Location: ../register.php');
		exit();
	}

	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	
	//get user data
	$response = $FB->get("/me?fields=id,name, first_name, last_name, email, picture.type(large)", $accessToken);
	$userData = $response->getGraphNode()->asArray();
	$_SESSION['userData'] = $userData;
	$_SESSION['access_token'] = (string) $accessToken;
	
	if(isset( $_GET['redirect'] )){
		header('Location:' . $_GET['redirect'] . '&fb_login=1');	
		exit;
	}else{
		header('Location: ../home.php?fb_login=1');
		exit;
	}
	
	exit();
?>
    