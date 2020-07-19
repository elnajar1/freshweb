<?php
	require_once "../includes/config.php";

	$library_id = filter_var ( $_GET['library_id'], FILTER_SANITIZE_NUMBER_INT );

	if(empty($library_id)){

		header("location: ../home.php");

	}

	//library info
	$sql ="SELECT * FROM fw_librarys WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $library_id ]);
	$library = $stmt->fetch();
	
	//group info
	$sql = "SELECT * FROM fw_groups WHERE id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $library['owner_id'] ]);
	$group = $stmt->fetch();

    //insert new book
    $errors = [];
    
	if (  $_SERVER['REQUEST_METHOD']  == 'POST'  ){
		
		$sciene_name = filter_var ($_POST["science-name"], FILTER_SANITIZE_STRING );
    	   $teacher_name = filter_var ($_POST["teacher-name"], FILTER_SANITIZE_STRING );
   	    $science_id = filter_var ($_POST["science-id"], FILTER_SANITIZE_NUMBER_INT );

		
		//errors
		if(empty( $sciene_name )){ $errors[] = "Please enter Science name";}
		
		//insert new science if it isn't exist on the dropdown menu
		
		if(empty( $science_id )){

			//check if this scienc was inserted before
			$sql ="SELECT * FROM fw_science WHERE  name LIKE ? ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $sciene_name . "%"]);
			$same_science = $stmt->fetch();
			$science_id = $same_science['id'];

			if(empty( $science_id )){
				//insert this new science
				$sql = "INSERT INTO fw_science ( name, creator_id) VALUES ( ? ,? )";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([ $sciene_name, $user_id]);
				$science_id = $pdo->lastInsertId();
				
			}
		}

		if (count($errors) == 0 ) {
			
			$sql = "INSERT INTO fw_books (library_id, science_id, teacher_name  , creator_id ) VALUES ( ? ,? , ? , ? )";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $library_id , $science_id , $teacher_name , $user_id ]);
			$id = $pdo->lastInsertId();
			header('Location: ' . $_SERVER['REQUEST_URI']);
			exit;
       		
    	}
	}

	//books
	$sql ="SELECT fw_books.id ,fw_books.teacher_name , fw_science.name
		FROM fw_books 
		JOIN fw_science ON fw_books.science_id = fw_science.id 
		WHERE library_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $library_id ]);
	$books = $stmt->fetchall();
	
	//check his role
	$sql = "SELECT * FROM fw_group_members WHERE user_id =?  AND group_id =? ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id  , $library['owner_id']  ]);
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
	
	include "../includes/header.php";
?>

<div class = "container"  >

	 <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fa fa-book m-2" ></i> </span>
            <h4 class =  "text-primary ">Books of <?= $library['name'] ?> library </h4>
            <br>
            <small class = "text-muted">create book that represent your subjects (sciences) , This book is like group of folders that contain your laerning files, videos , photos , records and more..
            </small>
        </div>
    </div>

	<div class=" row ">
   		<div class=" col alert alert-warning p-0 m-1">
            <?php
            	foreach ($errors as $error) {
            		echo $error . "<br>";
            	}
            ?>
		</div>
	</div>

	
	<div class = " row " >
		
		<?php foreach ($books as $book ): ?>
		<a href = "book.php?b=<?= $book['id'] ?>" class = "w-100  m-2 z-depth-1 bg-white rounded">
			<div class = " col-12" >
				<div class = " row " >
					<div class = " col-2 bg-dark " >
		  				<span style="font-size : 2em;"> <i class="fas fa-book text-light "></i> </span>
					</div>
					<div class = " col" >
						<p class = "w-100  "><?= $book['name'] ?></p>
						<small class = "text-muted">Teacher name : <?= $book['teacher_name'] ?></small>
					</div>
				</div>
			</div>
		</a>
		<?php endforeach; ?>

		<div class = " col-12 " style = "min-height:50vh" >
			<div class="text-center">
				<?php if ( ($role ==  "admin" ||  $role ==  "member") ){
					
					echo '<a href="" class="  btn btn-dark  btn-rounded" data-toggle="modal" data-target="#modalLoginAvatar"> + Add new book</a>' ;
				
					}else{
					echo '<button  class = "btn btn-danger  btn-rounded z-depth-0 " disabled > + Add new book ( join group frist )</button>' ;
				
					}
				
				?>
			</div>
		</div>

	</div>

	<div class = " row " >

		<div class = " col-12 col-md-6" >
			<!--Modal: Login with Avatar Form-->
			<div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
			        <!--Content-->
			        <div class="modal-content">

			            <!--Header-->
			            <div class="modal-header">
			                <img src = "<?=  $root ?>/layout/library/img/book.png"  class="rounded-circle img-responsive">
			            </div>
			            <!--Body-->
			            <div class="modal-body text-center mb-1">

			                <h5 class="mt-1 mb-2">Enter sceince of the book</h5>

			                <form action="#" method="post">
			                
				                <div class="md-form ml-0 mr-0 mb-0">
				                    <input type="text" id="science-name" name ="science-name" class="form-control form-control-sm  ml-0" required="true" autocomplete="off" >
				                    <input type="text" id = "science-id" name = "science-id" hidden="true" >
				                    <label for="science-name">science (subject) name *</label>
				                </div>

				                <div id = "science-suggestion-container" style = "overflow-y:scroll;max-height:200px"   class = " bg-white z-depth-1  "  >
	                			</div>

				                <div class="md-form ml-0 mr-0">
				                    <input type="text" id ="teacher-name" name ="teacher-name" class="form-control form-control-sm  ml-0" autocomplete="off" >
				                    
				                    <label for ="teacher-name">teacher name (optional) </label>
				                </div>

				               

				                <div class="text-center mt-4">
				                    <button  type = "submite" onclick="this.form.submit();this.disabled = true;" name ="add-book"  class="btn btn-cyan mt-1">Create</button>
				                </div>

			                </form>
			            </div>

			        </div>
			        <!--/.Content-->
			    </div>
			</div>
			<!--Modal: Login with Avatar Form-->
		</div>

	</div>
	
	<div   class = "row  border-top bg-dark text-light mt-3 py-3">
		<div class = "col ">
			<p>
				Owner : 
				<a href = "<?= $root . '/group/groupProfile.php?g='  . $group['id'] ?>" ><?= $group['name'] ?> </a> 
				group 
			</p>
			<small class = "d-block text-muted">group members only can  add new books </small>
		</div>
	</div>
	
</div>

<?php
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
    
