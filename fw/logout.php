<?php

	session_start(); // Start The Session

	session_unset(); // Unset The Data

	session_destroy(); // Destory The Session
	
	unset($_COOKIE['fw']);
	
	setcookie("fw", null  , time() /  1987654321);
	
	header('Location: register.php');

	exit();
