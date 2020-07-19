<?php
	include "../includes/connection.php";
	$search = filter_var (  $_POST['search'] , FILTER_SANITIZE_STRING  ) ; 
	
	//university 
	$sql ="SELECT * FROM fw_science_field WHERE  name LIKE ? LIMIT 4 ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%" ]);
	$science_fields = $stmt->fetchall();
	
	if(  count($science_fields) > 0  ){
		
		foreach( $science_fields as $science_field ){
			
			echo ' <div id = "' .  $science_field['id'] .  '"   class = " add-science-field-suggestion p-1  w-100  border border-0 d-block bg-white  ">' ;
				echo  $science_field['name'];
			echo '</div><hr>';
		}
		
	}elseif( count($science_fields) == 0  ){
		echo '<small class ="text-muted">search for your  science field and if your faculty (science field)  name dosn\'t exist write it</small>' ;
	}

?>
<!-- team  js -->
<script src="/fw/layout/group/js/main.js"></script>


  
