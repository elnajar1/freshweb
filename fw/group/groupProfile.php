<?php
	include "../includes/config.php";
	
	@$group_id = filter_var (  $_GET['g'], FILTER_SANITIZE_NUMBER_INT ) ;

	$sql = "SELECT * FROM fw_groups WHERE id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$group_id]);
	$group = $stmt->fetch();
	
	if(empty($group_id) || count($group) == 1 ){

		header("location: ../home.php");
		exit;

	}
	
	/*
	$sql = "SELECT fw_librarys.id , fw_librarys.name , fw_edu_stage.name  , fw_edu_stage.arabic_name, fw_edu_level.name  , fw_edu_level.arabic_name , fw_edu_level.name  , fw_edu_level.arabic_name , fw_edu_semester.name  , fw_edu_semester.arabic_name 
		FROM fw_librarys 
		LEFT JOIN fw_edu_stage ON fw_librarys.edu_stage_id =  fw_edu_stage.id
		LEFT JOIN fw_edu_level ON fw_librarys.edu_level_id =  fw_edu_level.id
		LEFT JOIN fw_edu_semester ON fw_librarys.edu_semester_id =  fw_edu_semester.id 
		WHERE fw_librarys.owner_id = ? AND fw_librarys.owner_type = ? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$group_id , "group"]);
	$librarys = $stmt->fetchall();
	*/
		
	//librarys
	$sql = "SELECT fw_librarys.id AS 'library_id' ,
		 fw_librarys.name AS 'library_name' , 
		 fw_groups.name AS 'group_name', 
		 fw_edu_stage.name  AS 'stage_name' , fw_edu_stage.arabic_name AS 'stage_arabic_name', 
		 fw_edu_level.name AS 'level_name' , fw_edu_level.arabic_name AS 'level_arabic_name' , 
		 fw_edu_semester.name AS 'semester_name' , fw_edu_semester.arabic_name AS 'semester_arabic_name', 
		 
		 fw_university.name AS 'university_name' ,
		 fw_science_field.name As 'science_filed_name' 
		FROM fw_librarys 
		LEFT JOIN fw_edu_stage ON fw_librarys.edu_stage_id =  fw_edu_stage.id
		LEFT JOIN fw_edu_level ON fw_librarys.edu_level_id =  fw_edu_level.id
		LEFT JOIN fw_edu_semester ON fw_librarys.edu_semester_id =  fw_edu_semester.id 
		LEFT JOIN fw_groups  ON fw_librarys.owner_id = fw_groups.id
		LEFT JOIN fw_university  ON fw_groups.university = fw_university.id  
		LEFT JOIN fw_science_field  ON fw_groups.science_field  = fw_science_field.id
		WHERE   fw_librarys.owner_type = ? AND fw_groups.id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "group", $group_id]);
	$librarys = $stmt->fetchall();
	
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
	
	//get reqests
	$sql = "SELECT fw_group_members.* , fw_users.* 
		FROM fw_group_members 
		LEFT JOIN fw_users ON fw_group_members.user_id = fw_users.id
		WHERE group_id =?  AND fw_group_members.status = ? ORDER BY fw_group_members.status";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([  $group_id , 0]);
	$members = $stmt->fetchall();
	$count_members = $stmt->rowCount();
	
	//followed librarys files
	$sql ="SELECT f.id AS 'file_id',f.author,  f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
		science.name AS 'science_name', 
		section.name AS 'section_name' , 
		g.id AS 'group_id', 
		g.name AS 'group_name', 
		u.name  AS 'user_name', u.id AS 'user_id' , u.fb_name, u.avatar, u.fb_avatar, 
		DATEDIFF(NOW(), f.time) AS 'days' 
		 FROM 
		 fw_files f, fw_books b, fw_science science, fw_sections section, fw_users u, 
		fw_groups g, fw_librarys l
		
		 WHERE 
		 g.id  = ? AND
		 l.id = b.library_id AND
		 g.id = l.owner_id AND
		 section.id = f.c_section_id AND
		 b.id = f.book_id AND
		 science.id = b.science_id AND
		 u.id = f.uploader_id
		ORDER BY  f.time DESC LIMIT 10";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $group_id]);
	$group_files = $stmt->fetchall();
	
	//var_dump ($role);
	//var_dump ($members);
	include "../includes/header.php";
?>

<div class="container ">
	
	<div class=" row bg-dark text-light">
			<div class=" col ">
				<h3 class="font-weight-bond my-4 text-center text-white  w-100"><?= $group['name'] ?></h3>
			</div>
	</div>
	
	<div class=" row bg-dark text-light ">
	
		<div class="col-6  ">
			<?php 
				
				if( $role == "visitor"  && isset($user_id) ):
					
					echo '<button id = " ' .   $group['id']  . '" class = "group-join btn btn-primary btn-block btn-sm  z-depth-0">Join</button>';
				
				elseif($role  == "requested"):
				
					echo '<button id = " ' .   $group['id']  . '" class = " btn text-dark btn-block btn-sm  z-depth-0" disabled>Request sended</button>';
				
				elseif($role  == "member"  ||  $role  == "admin" ):
				
					echo '<button class = " btn text-dark btn-block btn-sm  z-depth-0" disabled>you are ' . $role .   '</button>';
				
				elseif( empty($user_id)):
				
					echo '<a href ="' . $root  . '/register.php"  class = " btn btn-danger  btn-block btn-sm  z-depth-0" >Sing in to join</a>';
				
				endif;
			?>
		</div>
		
		<div class="col text-center">
			<a class = " text-light " href = "<?= $root  ?>/group/groupMembers.php?group_id=<?= $group_id ?>">
				<span style="font-size : 1em;"> <i class="fas fa-users d-block"></i> </span>
				<small>members</small>
			</a>
		</div>
		
		<div class="col   text-center  ">
			<p id = "<?= $domain . $root ?>/group/groupProfile.php?g=<?= $group_id ?>"  class = "share">
				<span  style="font-size : 1em" ><i class = "fa fa-share d-block "></i></span>  
				 <small >Share</small>
			</p>
		</div>	
		
	</div>

	<div class=" row bg-white border-bottom text-center ">
		<div class="col link-active">
			<a href  = "#" >Home</a>
		</div>
		<div class="col   ">
			<a href = "<?= $root ?>/messages/chatroom.php?g=<?= $group_id ?>#send-message">Group chat room</a>
		</div>
	</div>
	
	<div class=" row">

		<div class="col-12 w-100">
			<span class = "border-bottom text-muted">Group Librarys</span>
			<?php if ( ($role ==  "admin" ||  $role ==  "member") ): ?>
			<a href = "/fw/library/addLibrary.php?type=group&group_id=<?= $group_id ?>" class = "float-right ">Create Library for this group </a>
			<?php endif; ?>
		</div>
		
	</div>
	
	<div class=" row  ">
		<?php if ( count($librarys) == 0 &&  ($role ==  "admin" ||  $role ==  "member") ): ?>
		<div class="col add-library-advise text-white   z-depth-1 rounded m-2 p-3">
			<h3 class = "text-shadow">You haven't created any librarys yet </h3>
			<p class = "text-shadow">make library now to upload and organize your files</p>
			<br>
			<a href = "/fw/library/addLibrary.php?type=group&group_id=<?= $group_id ?>" class = "btn btn-white ">Create Library for this group </a>
		</div>
			
		<?php 
			else: 
			foreach ($librarys as $library):
		?>

		<div class="col-12 w-100 ">
	
			<div class="card my-2">
				<div class="card-header library-header text-white text-shadow">
					<h6 class="card-title font-weight-bold text-white">
						<?= $library['group_name'] ?>  group
					</h6>
					<small class="card-text d-block">
						<?= $library['science_filed_name'] ?>
						 - 
						<?= $library['university_name'] ?>
					</small>
				</div>
				<div class="card-body">
					<div class = "row">
					
						<div class = "col-9 p-0">
							<h5 class="card-title"><?= $library['library_name'] ?>  Library</h5>
							<p class="card-text d-block">stage : <?= $library['stage_arabic_name'] ?></p>
							<p class="card-text d-block">level : <?= $library['level_arabic_name'] ?> </p>
							<p class="card-text d-block">semester : <?= $library['semester_arabic_name'] ?></p>
							<a href="<?=  $root ?>/library/books.php?library_id=<?= $library['library_id'] ?>" class= "card-link d-block">Go to Library</a>
						</div>
						
						<div class = "col-3  p-0">
						
							<?php 
						
								//books
								$sql ="SELECT fw_books.id  AS 'book_id' ,fw_books.teacher_name , 
								fw_science.name AS 'name' 
								FROM fw_books 
								JOIN fw_science ON fw_books.science_id = fw_science.id 
								WHERE library_id = ?
								 ORDER BY fw_books.id DESC LIMIT 4 ";
								$stmt = $pdo->prepare($sql);
								$stmt->execute([ $library['library_id'] ]);
								$books = $stmt->fetchall();
							
								foreach ($books as $book):
								 
							?>
								
								<a href ="<?=  $root ?>/library/book.php?b=<?=  $book['book_id'] ?>">
									
									<small class=" d-block border-bottom">
										<span  <i class="fas fa-book"></i> </span>
										<?= substr($book['name'],0,8) ?>
									</small>
									
								</a>
								
							<?php endforeach; ?>
							
								<a href="<?=  $root ?>/library/books.php?library_id=<?= $library['library_id'] ?>" >
								
									<small class=" d-block text-info">
										See All
									</small>
									
								</a>
								
						</div>
						
					</div>
				</div>
			</div>
			
		</div>

		<?php 
			endforeach;
			endif;
		 ?>
		
	</div>
	
	<?php
	if( $role == "admin"  && $count_members !== 0):
	?>
	
		<div class ="row">
			<div class = "col">
				<p class = "text-muted">New Requests</p>
			</div>
		</div>
		
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
	
	<br>
	
	<?php get_posts ($group_files); ?>
	
</div>
    
<?php
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
    
    
    
    
    
