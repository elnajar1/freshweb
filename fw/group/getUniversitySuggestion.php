<?php
	include "../includes/connection.php";
	$search = filter_var (  $_POST['search']  , FILTER_SANITIZE_STRING  ) ; 
	
	//university 
	$sql ="SELECT * FROM fw_university WHERE  arabic_name LIKE ? OR name  LIKE  ? OR  short_name  LIKE ? LIMIT 4";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%" , "%" .  $search .  "%" ,  "%" .  $search .  "%" ]);
	$unversitys = $stmt->fetchall();
	
	if(  count($unversitys) > 0  ){
		
		foreach( $unversitys as $university ){
			
			echo ' <div id = "' .  $university['id'] .  '"   class = "  add-university-suggestion p-1  w-100  border border-0 d-block bg-white  ">' ;
				echo $university['arabic_name'];
				if(empty( $university['arabic_name'])){
					echo $university['name'];
				}
			echo '</div><small class = "text-muted">' .  $university['name'] .  '</small><hr>';
		}
		
	}elseif( count($unversitys) == 0  ){
		echo '<small class ="text-muted">search for your  university and if your university name dosn\'t exist write it</small>' ;
	}

?>
<!-- team  js -->
<script src="/fw/layout/group/js/main.js"></script>


  
