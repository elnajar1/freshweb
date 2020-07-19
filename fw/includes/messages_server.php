<?php

	//Bismi Alaah
	function unique_multidim_array($array, $key) { 
    	$temp_array = array(); 
    	$i = 0; 
           $key_array = array(); 
    
    	 foreach($array as $val) { 
       	 if (!in_array($val[$key], $key_array)) { 
            	$key_array[$i] = $val[$key]; 
            	$temp_array[$i] = $val; 
        	} 
        	$i++; 
   	 } 
    	return $temp_array; 
	} 
	
	if(isset( $user_id )){
    	    
    	//groups chatrooms
    	$sql = "SELECT g.*, 
    		u.name AS 'user_name' , u.fb_name,
    		g_c.text, g_c.sender_id, g_c.readed, 
    		DATEDIFF(NOW(), g_c.time) AS 'days' 
    		FROM
    		 fw_groups g, 
    		 fw_users u, 
    		 fw_group_chatroom g_c, 
    		 fw_group_members  
    		WHERE  
    		fw_group_members.user_id = ?
    		 AND 
    		 fw_group_members.status = ?
    		 AND
    		 g.id  = fw_group_members.group_id
    		 AND 
    		 g_c.group_id = g.id
    		 AND
    		 g_c.sender_id = u.id
    		ORDER BY g_c.time DESC
    		";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute([ $user_id, 1]);
    	$count_chatrooms = $stmt->rowCount();
    	$chatrooms = $stmt->fetchall();
    	$chatrooms = unique_multidim_array( $chatrooms,"name");
    	
    	//converision
    	$sql = "SELECT  DISTINCT c.id , u.id AS 'user_two_id' ,  u.name, u.fb_name , u.avatar, u.fb_avatar
    	, c_r.text, c_r.sender_id, c_r.readed, c_r.time, 
    	DATEDIFF(NOW(), c_r.time) AS 'days' 
    	FROM
    	fw_users u, 
    	fw_conversation c, 
    	fw_conversation_replay c_r
    	WHERE 
    	(
    		(user_one_id = u.id AND user_two_id = ?) 
    	OR (user_two_id = u.id AND user_one_id = ?)
    	) 
    	AND
    	c.id = c_r.c_id
    	/*GROUP BY c.id*/
    	ORDER BY c_r.time DESC
    	";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute([ $user_id, $user_id ]);
    	$conversations = $stmt->fetchall();
    	$count_conversations = $stmt->rowCount();
    	
    	$conversations  = unique_multidim_array( $conversations , "id");
    	
    
    		
    	//suggested users
    	$user_one = $user_id;
    	$sql = "SELECT * FROM fw_users 
    	ORDER BY RAND() LIMIT 7";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute();
    	$users = $stmt->fetchall();
    	
    	
    	//count unreaded  conversions
    	$unreaded_messages  = 0;
    	foreach($chatrooms as $c){
    		if( $c['readed']  == 0  && $c['sender_id'] !== $user_id ){
    			$unreaded_messages++;
    		}
    	}
    	
    	foreach($conversations as $c){
    		if( $c['readed']  == 0  && $c['sender_id'] !== $user_id ){
    			$unreaded_messages++;
    		}
    	}
    	
	}	
	
