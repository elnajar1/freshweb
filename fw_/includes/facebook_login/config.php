<?php
	if(!isset($_SESSION )){
		/*
		// server should keep session data for AT LEAST 1 hour
		ini_set('session.gc_maxlifetime', 31234567);

		// each client should remember their session id for EXACTLY 1 hour
		session_set_cookie_params(31234567);
		*/
		session_start();
		
	 } 
	//app sittengs
	require_once "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => '267340977520365',
		'app_secret' => 'b7270f3af3ae037c066677fc4c93132d',
		'default_graph_version' => 'v2.10'
	]);

define('APP_URL', 'https://freshweb.ml/fw/') ;
	$helper = $FB->getRedirectLoginHelper();
	@$_SESSION['FBRLH_state']=$_GET['state'];
?>
