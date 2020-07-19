<?php 

	include '../includes/header.php' ;
	

	$user_one_id = $user_id;
	$user_two_id = filter_var($_GET['user_two_id'], FILTER_SANITIZE_NUMBER_INT); 

	$sql = "SELECT id FROM fw_conversation 
		WHERE (user_one_id = ? AND user_two_id = ?) 
		OR (user_two_id = ? AND user_one_id = ?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_one_id , $user_two_id , $user_one_id ,$user_two_id]);
	$c = $stmt->fetch();
	$count_c = $stmt->rowCount();

	if($count_c == 1){

		$c_id = $c['id'];
		

	}elseif($count_c == 0 ){
		$sql = "INSERT INTO fw_conversation (user_one_id , user_two_id ) VALUES (?,?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$user_one_id , $user_two_id]);
		$c_id = $pdo->lastInsertId();
		
	}


	//user_info
	$sql = "SELECT * FROM fw_users 
	WHERE id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute( [ $user_two_id ]);
	$user_info = $stmt->fetch();

?>

<div class="container bg-flower">

	<div class=" row bg-dark ">
		<div class=" col-3 ">
			<img src="
				<?php 
					if(isset($user_info['avatar'])){
						echo $root . "/uploads/avatars/" . $user_info['avatar'];
								
								
					}else{
						echo  $user_info['fb_avatar'];
					}
				?>
				" class="w-50 d-block mx-auto m-3 img-fluid rounded border border-light  z-depth-1" onerror="this.src='/fw/uploads/avatars/user.jpeg';"  />
			
		</div>
			
		<div class=" col ">
			<h5 class=" my-3 font-weight-light  text-light ">
				<?php
					if(isset($user_info['name'])){
						echo $user_info['name'] ;
					}else{
						echo $user_info['fb_name'] ;
					}	
				?>
			</h5>
		</div>
	</div>
	
	<div class=" row bg-white border-bottom text-center ">
		<div class="col ">
			<a href  = "<?= $root . '/user/profile.php?u=' . $user_two_id ?>" > 
				Shared files 
			</a>
		</div>
		<div class="col  link-active ">
			<a href = "<?= $root ?>/messages/chat.php?user_two_id=<?= $this_user_id ?>"> 
				chat now
			</a>
		</div>
	</div>
	
		
	<div id  = "messages"  style = "min-height:25vh;max-height:75vh;overflow-y:scroll">
	</div>
			
	  <div class =  "row " >
   	 	<div  class="  col-12 p-0  ">
   	 		
   	 		<form class = " bg-white " action = "#"  id = "send-message" >
      			<textarea style = "width:80%" type="text" id = "chat-textarea" name="text" placeholder="Type message" class="form-control  d-inline-block   "  ></textarea>
      			<button  type="submit" name="submit-message" value="send" class="p-3 mb-5 btn rounded-circle text-center p-3   btn-sm   d-inline-block btn-dark " >
      				<span class = "text-whit">
      					<i class="fas fa-fighter-jet"></i>
      				</span>
      			</button>
     		 	<input type="text" id="c_id" name="c_id" value="<?= $c_id ?>" hidden />
     		</form>
     	
     	 </div>
	</div>
	
</div>

<?php 

include '../includes/footer.php' ;
//include "../../fresh_code/index.php";
?>
    
    
