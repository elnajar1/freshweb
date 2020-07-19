<?php
	include '../includes/config.php';

	
	$file_id = filter_var ($_POST['file_id'], FILTER_SANITIZE_NUMBER_INT );
	
	if(!empty($user_id) ){
		
		 $stmt =  $pdo->prepare('SELECT id  FROM fw_file_love WHERE file_id = ? AND user_id = ? ');
 		$stmt->execute([$file_id, $user_id]);
 		$count_love = $stmt->rowCount();
 		
	}else{
		
		$stmt = $pdo->prepare('SELECT id  FROM fw_file_love WHERE file_id = ?  AND  ip = ?');
 		$stmt->execute([$file_id ,$ip]);
 		$count_love = $stmt->rowCount();
 		
	}
	
		
	if( !empty($file_id)  &&  $count_love < 1){
		
		if(!empty($user_id) ){
			$sql = "INSERT INTO fw_file_love (file_id , user_id , ip  ) VALUES (? , ? , ? ) ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$file_id, $user_id, $ip]);
			
		}else{
			$sql = "INSERT INTO fw_file_love (file_id  , ip  ) VALUES (?  , ? ) ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$file_id,  $ip]);
			
		}
		
	}
	
	
	
	
	
	
	
    
