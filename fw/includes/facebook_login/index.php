<?php
	session_start();

	if (!isset($_SESSION['access_token'])) {
		header('Location: ../register.php');
		exit();
	}

echo '<a href = "logout.php">logout</a>' ;

var_dump(  $_SESSION['userData' ] );	

echo  "<br>Access Token :- <br>" ;

echo  $_SESSION['access_token'];
			
?>
	
<img  src="<?php echo $_SESSION['userData']['picture']['url'] ?>">
			
