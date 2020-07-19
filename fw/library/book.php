<?php
	// the hole library will be #! col-6 in all pages
	require_once "../includes/config.php";
	
	@$book_id = filter_var ( $_GET['b'], FILTER_SANITIZE_NUMBER_INT );
	
	if ( empty( $book_id ) ){
		header ("location: ../home.php");
		exit;
	}
	
	//book info
	$sql ="SELECT fw_books.teacher_name , fw_science.name
		FROM fw_books 
		LEFT JOIN fw_science ON fw_books.science_id = fw_science.id 
		WHERE fw_books.id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $book_id ]);
	$count_book  = $stmt->rowCount();
	$book = $stmt->fetch();
	
	if (  $count_book  == 0){
		header ("location: ../home.php");
		exit;
	}
	
	@$c_section_id = filter_var ($_GET['c_section_id'], FILTER_SANITIZE_NUMBER_INT );
	if(empty($c_section_id)){
		$c_section_id = "0";
	}
	
	
	//to be #mentioned (taged) #! 
	// mintion file (mintion button - > open library, select file radio input, fixed ok button)
	$auther_name = "test";
	
	

	//sections
	$sql ="SELECT * FROM fw_sections WHERE c_section_id = ? AND book_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$c_section_id , $book_id ]);
	$sections = $stmt->fetchall();
		
	//Book info
	$sql = "SELECT g.id AS 'group_id', g.name  AS 'group_name' ,
		 l.id AS 'library_id' , l.name AS 'library_name' ,
		  u.name AS 'university_name', u.url, 
		 sf.name AS 'science_field_name' ,
		 stage.name AS 'stage_name' , level.name AS 'level_name' , semester.name AS 'semester_name' ,
		 stage.arabic_name AS 'stage_arabic_name' , level.arabic_name AS 'level_arabic_name', semester.arabic_name AS 'semester_arabic_name' 
		FROM
		 fw_groups AS  g,
		 fw_librarys AS l, 
		 fw_books AS b, 
		 fw_university AS u, 
		fw_science_field AS sf, 
		fw_edu_stage AS stage, fw_edu_level AS level, fw_edu_semester AS semester   
		WHERE 
		g.id = l.owner_id AND
		l.id = b.library_id AND l.owner_type =? AND
		b.id = ?  AND 
		u.id = g.university AND 
		sf.id = g.science_field AND
		stage.id  = l.edu_stage_id AND
		level.id  = l.edu_level_id AND
		semester.id  = l.edu_semester_id 
		 ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(["group", $book_id ]);
	$info = $stmt->fetch();
	
	
	//check his role
	$sql = "SELECT * FROM fw_group_members WHERE user_id =?  AND group_id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id  , $info['group_id'] ]);
	$status = $stmt->fetch();	
	$count_status = $stmt->rowCount();
	
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
	
	//echo $role;
	
	/*
	echo "<pre>";
	var_dump($book);
	var_dump($info);
	echo "</pre>";
	*/
		
	include "../includes/header.php";
?>


<div class = "container bg-dark">

	<div  class = " row  text-light py-1" >
		<div class = " col " >
			<!-- used by js to post ajax info -->
			<div class = "book-id d-none" ><?= $book_id ?></div>
			<div class = "role d-none" ><?= $role  ?></div>
			<!-- /used by js to post ajax info -->
			<div class = " row " >
			
				<div class = " col " >
					<p class="text-white">
					Library : <a href="<?=  $root ?>/library/books.php?library_id=<?= $info['library_id'] ?>" > <?= $info['library_name'] ?>  </a>
					<small class = "text-muted d-block">
						<span > <i class="fas fa-info-circle "></i> </span>
						info : <?= $info['stage_arabic_name'] ?>  - <?= $info['level_arabic_name'] ?>    - <?= $info['semester_arabic_name'] ?>   
					</small>
					<p>
				</div>
				
			</div>
			
			<div class = " row " >
			
				<div class = " col " >
					<h3 class = "text-center  text-white font-weight-bold w-100 py-2 ">
						<span > <i class="fas fa-book m-1"></i> </span>
						<?= $book['name'] ?>
					</h3>
					
					<small class = "text-primary d-block">
						<?= $info['science_field_name'] ?>
						 - 
						<?= $info['university_name'] ?> 
					</small>
					
					<small>
						Teacher name : <?= $book['teacher_name'] ?>
					</small>
				</div>
				
			</div>
			
		</div>
	</div>
	
	<?php
		
		if(isset($_GET['f'])){
			//random files
			$sql ="SELECT f.id AS 'file_id',  f.author, f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
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
			f.id = ? ";
			
			$stmt = $pdo->prepare($sql);
			$file_id = filter_var ( $_GET['f'] , FILTER_SANITIZE_NUMBER_INT  ) ;
			$stmt->execute([ $file_id  ]);
			$shared_file = $stmt->fetchall();
			
			get_posts( $shared_file );
		
			echo '<div class =" text-center  ">
			   <h1 class ="text-white font-weight-bond d-inline-block"> W   a n  t </h1>
			   <h3 class ="text-primary d-inline-block">m   o r   e </h3>
			   </br>
			   <h4 class ="text-primary  d-inline-block">c l i c k  </h4>
			   <h2 class ="text-white  d-inline-block text-shadow  ">B u t o n s </h2>
			   </div>' ;
			   
		}

	?>
	
	
	
	<div class = "row">	
		<div style = "max-width=250px" class = "col-12" >
			<div class = "add-section-form-container bg-white p-1 rounded z-depth-1  mx-auto">
			</div>
		</div>
	</div>
	
	<?php if( count($sections) == 0):  ?>
	<div class = "row ">	

		<div class = "col my-4 w-100" >
			<h3 class = "text-center text-success">Lest's creat your first folder<h3>
		</div>
		
	</div>
	
	<?php else: ?>
	
	<div class = "row">	

		<div class = "col my-4  w-100" >
			<h3 class = "text-center text-muted my-3">Lectures folders<h3>
		</div>
		
	</div>
	<?php endif; ?>

	<div class = "row  " style = "min-height:250px">	
	
		<div class = "col " >
				<?php foreach( $sections as $s ){  ?>

					<button id = "<?= $s['id'] ?>" class ="show-section-content   p-2 btn btn-primary  btn-block "  >
						<i class="far fa-folder"></i> 
						<?= substr(htmlspecialchars($s['name' ]) , 0, 50) ?> 
					</button>
					
					<?php  if( $role ==  "member"  || $role ==  "admin" ): ?>

					<button value = "<?= $s['id'] ?>"  id = "add-section-<?= $s['id'] ?>" style = "display : none ;font-size : 8px; "  class = "add-section text-dark border border-dark border-top-0  btn btn-sm   m-0  z-depth-0 ">
						Add New  Subfolder
        				</button>

        			<?php endif; ?>

    				<div id = "section-<?= $s['id'] ?>"  class = "border-left border-primary  p-1">
    				</div>
        				
        			<?php } 
        			
        			if( $role ==  "member"  || $role ==  "admin" ):
        			
        			?>
        			
        			<button value  = "0"   class = "add-section p-2 btn  btn-block  btn-success">
					Add a new main folder
        			</button>
        			
        			<?php else: ?>
        			
        			<button    class = " p-2 btn  btn-block  btn-danger   disabled z-depth-1" disabled >
					Add a new main folder
					<small class = "d-block ">join group frist</small>
        			</button>
        			
        			<?php endif; ?>
		</div>
		
	</div>
	
	<div class = "row">
		<div class = "col">
			<p class ="d-block border-bottom text-muted">
				 other this library books 
				</p>
			<?php 
						
				//books
				$sql ="SELECT fw_books.id  AS 'book_id' ,fw_books.teacher_name , 
					fw_science.name AS 'name' 
					FROM fw_books 
					JOIN fw_science ON fw_books.science_id = fw_science.id 
					WHERE library_id = ?
					 ORDER BY fw_books.id DESC ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([ $info['library_id'] ]);
				$books = $stmt->fetchall();
							
				foreach ($books as $book):
								 
			?>
								
					<a href ="<?=  $root ?>/library/book.php?b=<?=  $book['book_id'] ?>&s=BookBadge">
									
						<small class="  badge badge-pill badge-primary">
							<span  <i class="fas fa-book"></i> </span>
							<?= $book['name']  ?>
						</small>
									
					</a>
								
				<?php endforeach; ?>
							
				<a href="<?=  $root ?>/library/books.php?library_id=<?= $info['library_id'] ?>" >
								
					<small class=" badge badge-pill badge-info">
						See All
					</small>
									
				</a>
								
		</div>
						
	</div>
	<div id = "group-info" class = "row  border-top text-white mt-3 py-3">
		<div class = "col ">
			<p class="text-white">
				Owner : 
				<a href = "<?= $root . '/group/groupProfile.php?g='  . $info['group_id'] ?>" ><?= $info['group_name'] ?> </a> 
				group 
			</p>
			<small class = "d-block text-muted">group members only can  <span class =  " p-1 text-white border border-white  rounded "><i class="fa fa-cloud-upload-alt "> upload </i></span></small>
		</div>
	</div>
        
</div>
     
    
<?php 
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
    
    
    
    
    
