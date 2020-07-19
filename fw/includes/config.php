<?php

	//Bismi Alaah
	include 'connection.php';
	//roots &  directorys
	$root = "/fw";
	$GLOBALS['root'] = $root;
	$domain = "https://" . $_SERVER['HTTP_HOST'];
	$GLOBALS['domain'] = $domain;
	$ip = $_SERVER['REMOTE_ADDR']; 
	$GLOBALS['ip'] = $ip;
	include 'server.php';
	
	error_reporting ( 0 );
	/*
	echo "<pre>";
	var_dump($_SERVER) ;
	*/
date_default_timezone_set('Africa/Cairo');	
    
