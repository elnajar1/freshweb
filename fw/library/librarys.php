<?php

	include "../includes/header.php";
	
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
		LEFT JOIN fw_group_members  ON fw_group_members.user_id  =?
		WHERE   fw_librarys.owner_type = ? AND fw_groups.id = fw_group_members.group_id AND fw_group_members.status  =? AND  fw_group_members.user_id  =?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id, "group"  , 1, $user_id]);
	$librarys = $stmt->fetchall();
	
	/*
	echo "<pre>";
	var_dump($librarys);
	echo "</pre>";
	*/
		
?>

<div class = "container-fluid ">
	
	<div class = " row " >
		<div class = " col " >
			<h3 class = "text-center text-white m-3" >Followed Librarys</h3>
			<small class =  "text-muted ">  
				Here will see your library that you creat or from groups that you joined
			</small>
		</div>
	</div>

	<div class=" row  ">
		<?php if ( count($librarys) == 0 ): ?>
		
			<h4 class = "my-5">You haven't joinded any group yet </h3>
			
		<?php 
			else: 
			foreach ($librarys as $library):
		?>

		<div class="col-12 w-100 ">
	
			<div class="card my-2">
				<div class="card-header library-header text-white text-shadow">
					<h5 class="card-title  text-white font-weight-bold">
						<?= $library['group_name'] ?>  group
					</h5>
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
	
	
</div>

<?php
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
    
    
