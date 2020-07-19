<?php 
	include '../includes/header.php' ;
	
	/*
	echo" <pre>";
	echo"<h1>group chatrooms</h1>";
	var_dump( $chatrooms );
	echo"<h1>conversions</h1>";
	var_dump( $conversations );
	echo "</pre>";
	*/

?>

<div class="container bg-white">
	
	<!--  chat rooms  -->
	<?php if( $count_chatrooms !== 0): ?>
	<div class=" row ">
		<div class=" col-12">
			<p class="text-muted border-bottom">Groups  chat rooms </p>
		</div>
	</div>
	
	<?php foreach($chatrooms as $c ) : ?>
	<a href = "chatroom.php?g=<?= $c['id']  ?>" class="w-100">
		
		<div class = "row p-1">
			<div class = "col  ">
				<p class = "text-dark font-weight-bold"><?= $c['name'] ?></p>
				  <br>
				<small class = "text-muted <?php if( $c['readed']  == 0 &&  $c['sender_id']  !== $user_id  ){ echo 'alert-warning p-1'; } ?>">
					<span class = "text-info"> <?= $c['user_name']  .  $c['fb_name']  ?> :  </span>
					 <?= substr( $c['text'], 0,100) ?> 
				</small>
			</div>
		
			<div class = "col-2 p-0 m-0">
				<small>
					 <span style = "font-size:10px" class = "text-muted"><?php if ($c['days'] == 0 ): echo 'Today' ; else: echo $c['days'] . ' days ago' ; endif; ?> </span>
					  <?= substr( $c['time'], 11 , -3 ) ?> 
				</small>
			</div>
		</div>
	</a>
	
	<hr>
	
	<?php 
		endforeach; 
	endif;
	?>
	
	<!--  conversations  -->	
	<?php if( $count_conversations !== 0): ?>
	<div class=" row ">
		<div class=" col-12">
			<p class="text-muted border-bottom"> Conversations </p>
		</div>
	</div>
	
	<?php foreach($conversations as $c ) : ?>
	<a href = "chat.php?user_two_id=<?= $c['user_two_id']  ?>" class="w-100">
		
		<div class = "row p-1">
		
			<div class = "col-3 m-0 ">
				<img style = "max-height:60px" src = "
					<?php if(isset($c['avatar'])){
							echo $root . '/uploads/avatars/' . $c['avatar'];
						}else{
							echo  $c['fb_avatar'];
					} ?>
				" class = "d-block mx-auto rounded img-fluid" onerror="this.src='/fw/uploads/avatars/user.jpeg';" />
			</div>
			
			<div class = "col  ">
				<p class = "text-dark"><?= $c['name'] ?></p>
				  <br>
				<small class = "text-muted <?php if( $c['readed']  == 0  &&  $c['sender_id']  !== $user_id ){ echo 'alert-warning p-1'; } ?>">
					<?= substr( $c['text'], 0,100) ?> 
				</small>
			</div>
		
			<div class = "col-2 p-0 m-0">
				<small>
					 <span style = "font-size:10px" class = "text-muted"><?php if ($c['days'] == 0 ): echo 'Today' ; else: echo $c['days'] . ' days ago' ; endif; ?> </span>
					  <?= substr( $c['time'], 11 , -3 ) ?> 
				</small>
			</div>
		</div>
		
	</a>
	
	<hr>
	
	<?php 
		endforeach; 
	endif;
	?>
	
	
	<!--  random users  -->
	
	<div class=" row ">
		<div class=" col-12">
			<p class="text-muted border-bottom">Suggested Students</p>
		</div>
	</div>
	
	<?php foreach($users as $user) : ?>
	<a href = "chat.php?user_two_id=<?= $user['id']  ?>">
		<div class = "row p-1">
			<div class = "col-3 m-0 ">
				<img style = "max-height:60px" src = "
				<?php if(isset($user['avatar'])){
					echo $root . "/uploads/avatars/" . $user['avatar'];
				}else{
					echo  $user['fb_avatar'];
				} ?>
				" class = "d-block mx-auto  rounded img-fluid" onerror="this.src='/fw/uploads/avatars/user.jpeg';" >
			</div>
		
			<div class = "col p-0 m-0">
				<p>
				 <?php
				 
				if(isset($user['name'])){
					echo $user['name'] ;
				}else{
					echo $user['fb_name'] ;
				}	
				 
				?>
				  </p>
				  <br>
				<small class = " w-100 text-muted "> Hi, ask me anythinge about eduction </small>
			</div>
		</div>
	</a>
	
	<hr />
	<?php endforeach; ?>
	
   
</div>

<?php 

include '../includes/footer.php' ;

?>
    
    
    
    
    
    
