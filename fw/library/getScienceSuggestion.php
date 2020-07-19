<?php
	include "../includes/connection.php";
	$search = filter_var( $_POST['search'], FILTER_SANITIZE_STRING );
	
	//science
	$sql ="SELECT * FROM fw_science WHERE  name LIKE ? LIMIT 5";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%" ]);
	$science = $stmt->fetchall();
	
	if(  count($science) > 0  ){
		
		foreach( $science as $science){
			
			echo ' <div id = "' .  $science['id'] .  '"   class = " add-science-suggestion p-1  w-100  border border-0 d-block bg-white  ">' ;
				echo  $science['name'];
			echo '</div><hr>';
		}
		
	}elseif( count($science) == 0  ){
		echo '<small class ="text-muted">search for your  science and if your science name dosn\'t exist write it</small>' ;
	}

?>
<!-- team  js -->
<script src="/fw/layout/group/js/main.js"></script>


  
