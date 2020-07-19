<?php 

	include "includes/header.php";
	
	//followed librarys files
	$sql ="SELECT f.id AS 'file_id',  f.author , f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
		science.name AS 'science_name', 
		section.name AS 'section_name' , 
		g.id AS 'group_id', 
		g.name AS 'group_name', 
		u.name  AS 'user_name', u.id AS 'user_id' , u.fb_name, u.avatar, u.fb_avatar, 
		DATEDIFF(NOW(), f.time) AS 'days' 
		 FROM 
		 fw_files f, fw_books b, fw_science science, fw_sections section, fw_users u, 
		fw_groups g, fw_group_members g_m, fw_librarys l
		
		 WHERE 
		 g_m.user_id  =? AND 
		 g_m.status  =? AND
		 l.id = b.library_id AND
		 g.id = l.owner_id AND
		 g.id = g_m.group_id AND
		 section.id = f.c_section_id AND
		 b.id = f.book_id AND
		 science.id = b.science_id AND
		 u.id = f.uploader_id
		ORDER BY  f.time DESC LIMIT 10";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id, 1 ]);
	$followed_files = $stmt->fetchall();
	$count_followed_files = $stmt->rowCount();
	
	//random files
	$sql ="SELECT f.id AS 'file_id',f.author,   f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
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
		 u.id = f.uploader_id
		ORDER BY RAND() LIMIT 5";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$random_files = $stmt->fetchall();
	/*
	echo "<pre>";
		print_r($followed_files);
	echo "</pre>";
	*/
	
	//random groups
	$sql = "SELECT fw_groups.name , fw_groups.id , fw_university.name , fw_science_field.name 
		FROM fw_groups   
		LEFT JOIN fw_university  ON fw_groups.university = fw_university.id  
		LEFT JOIN fw_science_field  ON fw_groups.science_field  = fw_science_field.id 
		ORDER BY RAND() LIMIT 3";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id, 1]);
	$mygroups = $stmt->fetchall();

?>

<!--Bismi Alaah-->

	

<div class=" container-fluid">


	<?php include 'search/searchBox.php'; ?>
	
	<div class = "row">
		<div class = "col-12 w-100">
			<p class ="d-block w-100 text-muted">
				 Suggested books 
				</p>
			<?php 
						
				//books
				$sql ="SELECT fw_books.id  AS 'book_id' ,fw_books.teacher_name , 
					fw_science.name AS 'name' 
					FROM fw_books 
					JOIN fw_science ON fw_books.science_id = fw_science.id 	
					 ORDER BY RAND() LIMIT 10 ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$books = $stmt->fetchall();
							
				foreach ($books as $book):
								 
			?>
								
					<a href ="<?=  $root ?>/library/book.php?b=<?=  $book['book_id'] ?>&s=HomeBadge">
									
						<small class="  badge badge-pill   badge-dark ">
							<span  <i class="fas fa-book"></i> </span>
							<?= $book['name']  ?>
						</small>
									
					</a>
								
				<?php endforeach; ?>
							
							
		</div>
						
	</div>

	
	
	<?php if ( $count_followed_files !== 0 ) : ?>
	<div class = "row">
		<div class = "col w-12">
	
		<p class = "text-muted  w-100" > 
				From Librarys that you joined
			 </p> 
		</div>
	</div>
	
		<?php   get_posts( $followed_files );  ?>
	
	<?php endif; ?>
	
	<?php if ( 1   == 1 ) : ?>
	<div class = "row">
		<div class = "col w-12">
			<p class = "text-muted text-center w-100" > 
				  Suggested groups  to join them
			 </p> 
		</div>
	</div>
	<?php endif; ?>
	
	<?php foreach ($mygroups as $mygroup): ?>

	<a href="<?= $root ?>/group/groupProfile.php?g=<?= $mygroup[1] ?>" class = "w-100" >
		<div class=" row m-1 p-1 border rounded bg-white text-dark z-depth-1 w-100"  style =" background: url(https://www.toptal.com/designers/subtlepatterns/patterns/sakura.png);" >
			<div class=" col">
				<p class="d-block font-weight-bold"><?= $mygroup[0] ?></p> 	
				<small class="text-muted "><?= $mygroup[3] ?> . <?= $mygroup[2] ?></small>
				<small class = "d-block text-center btn btn-primary btn-sm  rounded" > Join </small>
			</div>
		</div>
	</a>
	
	<?php endforeach; ?>
	
	<div class = "row">
		<div class = "col ">
			<p class = "text-muted text-center w-100 " >
				 What others posting on FreshWeb
			 </p> 
		</div>
	</div>
	
	<?php   get_posts( $random_files );  ?>

</div>   


<?php
include "includes/footer.php";
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
