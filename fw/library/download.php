<?php
	include "../includes/config.php";
	
	$file = filter_var ( $_GET['file'], FILTER_SANITIZE_STRING );
	$file_custom_name =filter_var ($_GET['file_custom_name'], FILTER_SANITIZE_STRING );
	$section_name = filter_var ($_GET['section_name'], FILTER_SANITIZE_STRING );
	

	$fileNameArray = explode("." , $file );
	$fileExtension = strtolower(end( $fileNameArray ));
       
       
	//visits analysis 
	$ip = $_SERVER['REMOTE_ADDR']; 
	$page = basename($_SERVER['PHP_SELF']);
	$url =$_SERVER['REQUEST_URI'];  
	
	$sql = "INSERT INTO fw_visits ( user_id, ip, page, url, host ) VALUES (?,?,?,?,? )";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id , $ip , $page, $url, $domain]);
	
       $file_custom_name = str_replace( "." .  $fileExtension , "" ,  $file_custom_name );
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-Length: ".filesize($file));
	header("Content-disposition: attachment; filename=\"" .  $section_name . '_'  . basename($file_custom_name) .   '.'  .  $fileExtension . "\""); 
	readfile($file); 
	

