<?php 

include '../includes/config.php' ; 
?>

<style>
p{
	overflow: scroll;
	
}
</style>

<script>
	function urlify(text) {
	    var urlRegex = /(https?:\/\/[^\s]+)/g;
    	return text.replace(urlRegex, function(url) {
      	  return '<a href="' + url + '">' + url + '</a>';
   	 })
 	   // or alternatively
    	// return text.replace(urlRegex, '<a href="$1">$1</a>')
	}
	
	//var text =  $('p' ).html();
	//$('p' ).html( urlify(text)  );
</script>

<?php

@$c_id = $_POST['c_id'];
@$group_id =  $_POST['group_id'];

if( isset ($c_id) ):

$stmt = $pdo->prepare("
	SELECT c_r.* ,  u.name, u.fb_name 
	FROM 
	fw_users u, 
	fw_conversation_replay c_r
	WHERE 
	u.id  = c_r.sender_id  AND
	c_id = ? 
	ORDER BY  id DESC  LIMIT 30");
$stmt->execute([$c_id]);
$messages = $stmt->fetchAll();

$sql = "UPDATE fw_conversation_replay c_r SET readed =? 
	WHERE 
	c_id = ? 
	AND NOT c_r.sender_id =? 
	";
$stmt = $pdo->prepare($sql);
$stmt->execute([1, $c_id, $user_id ]);

endif;

if( isset ($group_id) ):

	$sql = "SELECT fw_group_chatroom.* , u.name, u.fb_name 
		FROM fw_users u, fw_group_chatroom
		WHERE
		 u.id = fw_group_chatroom.sender_id AND
		fw_group_chatroom.group_id =? 
		ORDER BY  fw_group_chatroom.id DESC
		LIMIT 30";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$group_id]);
	$messages = $stmt->fetchAll();

$sql = "UPDATE fw_group_chatroom  SET readed =? 
	WHERE 
	fw_group_chatroom.group_id = ? 
	AND NOT fw_group_chatroom.sender_id =? 
	";
$stmt = $pdo->prepare($sql);
$stmt->execute([1, $group_id, $user_id ]);

 endif;
    
    
    
    
    
    
    
    



krsort ($messages);

echo '<div>';

foreach( $messages as $message ):

	if( $message["sender_id"] == $user_id   ):
	
		
		echo '<div  class = " d-block  ">';
			
			if( $message['readed'] == 1):
				echo '<span   style = "color: #6EB969;"><i class="fas fa-check-double"></i></span>';
			else:
				echo '<span class = "text-muted"><i class="fas fa-check"></i></span>';
			endif;
			echo '<p style = "background: #EFFFDE;max-width:90%" class = "  d-inline-block   rounded p-1">' . $message["text"] . '</p>' ;
		'</div>' ;
	else:
	
		
		echo '<div  class = " d-block  text-right  "><p class = "bg-white border   text-dark  rounded p-1">' ;
			
			echo '<small class = "d-block text-primary ">';
			if(isset( $message['name'] )){
				echo $message['name'] ;
			}else{
				echo $message['fb_name'] ;
			}	
			echo '</small >';
			
			echo $message["text"]  .  
		
		'</p></div>' ;
		
		
	endif;
	
endforeach;
	
echo '</div>';
