<?php
	
	include "../includes/config.php";
	
	//the visited profile user id
	@$get_id = filter_var ($_GET['u'], FILTER_SANITIZE_NUMBER_INT );
	 
	if ( isset(  $get_id )  && !empty ( $get_id ) ){
		
		$this_user_id = $get_id;
		
	}elseif( isset(  $user_id ) ){
		
		$this_user_id = $user_id;
		
	}else{
		header("Location: ../register.php");
		exit;
	}
	
	//user_info
	$sql = "SELECT * FROM fw_users 
	WHERE id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute( [ $this_user_id ]);
	$count_user = $stmt->rowCount();
	$user_info = $stmt->fetch();
	
	if( $count_user == 0 ){
		header("Location: ../register.php");
		exit;
	}
	
	//var_dump( $user_info );
	
	//user files
	$sql ="SELECT f.id AS 'file_id', f.author,   f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
		science.name AS 'science_name', 
		section.name AS 'section_name' , 
		u.name  AS 'user_name', u.id AS 'user_id' , u.fb_name, u.avatar, u.fb_avatar, 
		DATEDIFF(NOW(), f.time) AS 'days' 
		 FROM 
		 fw_files f, fw_books b, fw_science science, fw_sections section, fw_users u
		 WHERE 
		 section.id = f.c_section_id AND
		 b.id = f.book_id AND
		 science.id = b.science_id AND
		 u.id = f.uploader_id AND
		 f.uploader_id =? 
		ORDER BY f.time DESC LIMIT 20";
	$stmt = $pdo->prepare($sql);
	$stmt->execute( [ $this_user_id ]);;
	$user_files_count  = $stmt->rowCount();
	$user_files = $stmt->fetchall();
	
	//user files loves
	$stmt =  $pdo->prepare('SELECT fw_file_love.id  
	FROM fw_files f, fw_users u, fw_file_love 
	WHERE u.id = f.uploader_id AND
	f.id = fw_file_love.file_id AND
	f.uploader_id = ? 
	GROUP BY fw_file_love.id');
 	$stmt->execute([ $this_user_id ]);
 	$count_love = $stmt->rowCount();
 	$user_loves = $stmt->fetchall();
 	

	include "../includes/header.php";
?>

<div class=" container ">
	
	<div class=" row ">
		<div class=" col-12">
			<img src="
				<?php 
					if(isset($user_info['avatar'])){
						echo $root . "/uploads/avatars/" . $user_info['avatar'];
								
								
					}else{
						echo  $user_info['fb_avatar'];
					}
				?>
				" class="w-50 d-block mx-auto m-3 img-fluid rounded border border-light  z-depth-1" onerror="this.src='/fw/uploads/avatars/user.jpeg';" />
			<div class=" col ">
				<h3 class="font-weight-bold text-center text-light w-100">
					<?php
						if(isset($user_info['name'])){
							echo $user_info['name'] ;
						}else{
							echo $user_info['fb_name'] ;
						}	
					?>
				</h3>
			</div>
		</div>
	</div>
	
	<div class=" row p-4 rounded border z-depth-1 ">

		<div class="col">
			
			<span class="border rounded-circle  text-center m-2 p-3 bg-white">
				<i class="fa fa-cloud-upload-alt text-primary "></i>
			</span>
			<span class=" text-white font-weight-bold "><?= $user_files_count ?> </span>
			
		</div>

		<div class="col">
			
			<span class="border rounded-circle  text-center m-2 p-3 bg-white">
				<i class="fa fa-heart text-danger "></i>
			</span>
			<span class=" text-white font-weight-bold "><?= $count_love ?></span>

		</div>
	
	</div>
	
	<div class=" row bg-white border-bottom text-center py-0">
		<div class="col link-active">
			<a href = "#" > Shared files </a>
		</div> 
		
		<?php if ( $this_user_id !== $user_id ): ?>
		
		<div class="col">
			<a href = "<?= $root ?>/messages/chat.php?user_two_id=<?= $this_user_id ?>"> chat now</a>
		</div>
		
		<?php endif; ?>
		
	</div>
	
	<?php  if ( $user_files_count == 0 ): ?>
	
			<div class=" row ">
				<div class="col my-5 ">
					<h6 class ="w-100 text-center text-muted "> Has not  uploaded ( shared ) any files  yet </h6>
				</div>
			</div>
		
		<?php  
		
			else:
		
				get_posts ( $user_files ); 
				
			endif;
			
		?>
	
</div>
    
<?php
include "../includes/footer.php";
//include "../fresh_code/index.php";
    
    
    
