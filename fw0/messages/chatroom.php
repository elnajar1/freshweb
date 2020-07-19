<?php 
	
	include '../includes/config.php' ;
	
	$group_id = filter_var($_GET['g'], FILTER_SANITIZE_NUMBER_INT ); 
	
	//group info
	$sql = "SELECT * FROM fw_groups WHERE id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$group_id]);
	$group = $stmt->fetch();
	
	//check his role
	$sql = "SELECT * FROM fw_group_members WHERE user_id =?  AND group_id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id  , $group_id  ]);
	$status = $stmt->fetch();	
	$count_status = $stmt->rowCount();
	//print_r($status);
	
	// set role
	if($count_status == 0){

		$role = "visitor";
		
	}elseif( $count_status == 1 ){
		
		if( $status['role'] == "member" ){
			
			if( $status['status'] == 1  ){
				
				$role = "member";
				
			}elseif(  $status['status'] == 0 ){
				
				$role = "requested";
			}
		
		}elseif( $status['role'] == "admin" ){
			
			 $role = "admin";
		}

	}
	
	if (  $role ==  "visitor" ||  $role == "requested" ){
		
		header("location: " . $root . '/group/groupProfile.php?g=' . $group_id  );
		exit;
		
	}
	
	include '../includes/header.php' ;
?>

<div class="container">

	<div class=" row bg-dark ">
		
			
		<div class=" col ">
			<h5 class=" my-3 font-weight-light  text-light ">
				<?= $group['name'] ?> Chat room
			</h5>
		</div>
	</div>
	
	<div class=" row bg-white border-bottom text-center ">
		<div class="col ">
			<a href  = "<?= $root . '/group/groupProfile.php?g=' . $group_id  ?>" > 
				Home
			</a>
		</div>
		<div class="col  link-active ">
			 <a href ="#">
				chat room
			</a>
		</div>
	</div>
	
	<div class =  "row bg-flower " >
	       <div class=" col-12  ">
			<div id = "messages" style = "min-height:250px">
			
			</div>
		</div>
	</div>

	  <form  action = ""  id = "send-message" >
	       <div class =  "row  " >
	       
   	 	<div  class=" chat-sender bg-white col-12  p-1 w-100 ">
      			<textarea style = "width:80%" type="text" id = "chat-textarea" name="text" placeholder="Type message" class="form-control  d-inline-block  "  autofocus ></textarea>
      			<button  type="submit" name="submit-message" value="send" class="btn rounded-circle text-center p-3 mb-5 btn-sm   d-inline-block btn-dark ">
      				<span class = "text-whit">
      					<i class="fas fa-fighter-jet"></i>
      				</span>
      			</button>
     		 	<input type="text" id="group_id" name="group_id" value="<?= $group_id ?>" hidden>
     			 
     		 </div>
		
		</div>
	</form>
	
	
</div>

<?php 

include '../includes/footer.php' ;
//include "../../fresh_code/index.php";
?>
    
    
