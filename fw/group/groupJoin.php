<?php
	include "../includes/config.php";
	 
	 $group_id = filter_var ( $_POST['group_id'], FILTER_SANITIZE_NUMBER_INT );
	$sql ="INSERT INTO fw_group_members (group_id, user_id, role, status) VALUES (?,?,?,? )";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $group_id, $user_id, "member", 0]);
	
	
  
