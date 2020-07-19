<?php
	include "../includes/header.php";
	 
	 $group_id =filter_var (  $_GET['group_id'], FILTER_SANITIZE_NUMBER_INT );

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
	
	 //get members
	$sql = "SELECT fw_group_members.* , fw_users.* 
		FROM fw_group_members 
		LEFT JOIN fw_users ON fw_group_members.user_id = fw_users.id
		WHERE group_id =? ORDER BY fw_group_members.status";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([  $group_id  ]);
	$members = $stmt->fetchall();	
	
?>
<div class = "container">
	
	<?php
	if( $role == "admin" ):
	?>
	
		<div class ="row">
			<div class = "col">
				<p class = "text-muted">New Requests</p>
			</div>
		</div>
		
		<hr>
		
		<?php
		foreach($members as $member ):
			if( $member['status']  == 0 ):
		?>	
			<div class = "row p-1">
				<div class = "col-3 m-0 ">
					<img style = "max-height:60px" src = "
					<?php if(isset($member['avatar'])){
						echo $root . "/uploads/avatars/" . $member['avatar'];
					}else{
						echo  $member['fb_avatar'];
					} ?>
					" class = "rounded img-fluid m-1" >
				</div>
		
				<div class = "col p-0 m-0">
					<p class = "d-block ">
					<a href  = "<?= $root . '/user/profile.php?u=' . $member['user_id'] ?>" class = "text-dark font-weight-bold ">
					 <?php
					 
					if(isset($member['name'])){
							echo $member['name'] ;
						}else{
						echo $member['fb_name'] ;
						}	
				 
					?>
					</a>
				 	 </p>
				 	 
					  <br>
					  
					<button id = "<?=  $member['user_id'] ?>" value = "<?=  $group_id ?>"  class = " accept-join btn btn-sm btn-primary z-depth-0">accept</button>
					
					
				</div>
			</div>
	
	<?php
			endif;
		endforeach;
	endif;
		
	?>
	<div class ="row">
		<div class = "col">
			<p class = "text-muted">Group members</p>
		</div>
	</div>
	
	<?php
	foreach($members as $member ):
		if( $member['status']  == 1 ):
	?>	
		<div class = "row p-1">
			<div class = "col-3 m-0 ">
				<img style = "max-height:60px"src = "
				<?php if(isset($member['avatar'])){
					echo $root . "/uploads/avatars/" . $member['avatar'];
				}else{
					echo  $member['fb_avatar'];
				} ?>
				" class = "rounded img-fluid" >
			</div>
		
			<div class = "col p-0 m-0">
				<p class = "d-block ">
					<a href  = "<?= $root . '/user/profile.php?u=' . $member['user_id'] ?>" class = "text-dark font-weight-bold ">
					 <?php
					 
					if(isset($member['name'])){
							echo $member['name'] ;
						}else{
						echo $member['fb_name'] ;
						}	
				 
					?>
					</a>
				  </p>
				<?php  if( $member['role']  == "member"   && $role  == "admin" ): ?>
				  
					<button id = "<?=  $member['user_id'] ?>" value = "<?=  $group_id ?>" class = " member-to-admin btn btn-sm btn-primary z-depth-0">make admin</button>
				
				<?php  endif; ?>
			</div>
		</div>
		
		<hr>
		
	<?php
			endif;
		endforeach;
	?>
	</div>
	
</div>

<?php
	
include "../includes/footer.php";
