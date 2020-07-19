<?php 

include "includes/config.php";

if ( isset( $user_id )) {
  	header('location: home.php');
  	exit;
  }else{
  	
  	header('location: register.php');
  	exit;
  }
