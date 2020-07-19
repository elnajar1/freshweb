<?php
	include "../includes/config.php";
	
	$errors = [];
	$type = filter_var (  $_GET['type'], FILTER_SANITIZE_STRING );

	if(empty($type)){

		header("location: ../home.php");

	}

	if ($type == "personal" ) {
		
		$owner_id = $user_id;

	}elseif($type == "group") {

		$group_id = filter_var ($_GET['group_id'], FILTER_SANITIZE_NUMBER_INT );
		
		$owner_id = $group_id;

		//group info
		$sql = "SELECT * FROM fw_groups WHERE id =? ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$group_id]);
		$group = $stmt->fetch();


	}


	//stages
	$sql ="SELECT *FROM fw_edu_stage  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$stages = $stmt->fetchall();

	//levels
	$sql ="SELECT *FROM fw_edu_level  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$levels = $stmt->fetchall();

	//semesters
	$sql ="SELECT *FROM fw_edu_semester  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$semesters = $stmt->fetchall();


	if (  $_SERVER['REQUEST_METHOD']  == 'POST'  ){
		$errors = [];
		$library_name = filter_var ($_POST["library-name"], FILTER_SANITIZE_STRING );
		$stage = $_POST["stage"];
		$level = $_POST["level"]; 
		$semester = $_POST["semester"];
		
		//errors
		if(empty( $library_name )){ 
			$library_name  = filter_var ($group['name'], FILTER_SANITIZE_STRING );
		}
		if(empty( $stage && $level && $semester )){ $errors[] = "Please enter all required infromation";}

		if (count($errors) == 0 ) {
			
			$sql = "INSERT INTO fw_librarys ( name , owner_id , owner_type , edu_stage_id ,edu_level_id ,edu_semester_id , creator_id ) VALUES ( ? ,? , ? , ? , ? , ? ,?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $library_name , $owner_id , $type , $stage , $level , $semester , $user_id ]);
			$id = $pdo->lastInsertId();
       		header("location: books.php?library_id=" . $id);
    	}
	}


	//var_dump($_POST);

	include "../includes/header.php";
?>

<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fa fa-th-list m-2" ></i> </span>
            <h1 class =  "text-primary ">Create new Library</h1>
            <p class =  "text-info ">for <?= $group['name'] ?> group</p>
            <br>
            <small class = "text-muted">In Library you can <strong> organize </strong>with each other your lectures and learning files easily en'sh Allah
            </small>
        </div>
    </div>


    <div class=" row  ">
        <div class=" col   mx-auto z-depth-1 bg-white rounded p-3 m-2">
            <form action="#" method="post" ">
            
            	<div class=" col alert alert-warning p-0 m-1">
		            <?php
		            	foreach ($errors as $error) {
		            		echo $error . "<br>";
		            	}
		            ?>
        		</div>

                <div class="form-group md-form ">
                    <input type="text"  class="form-control" id = "library-name"  name = "library-name" value="" autofocus = "true" >
                    <label for = "library-name"> Library name </label>
                </div>
                
                <div class="form-group ">
	                <label>Chose Educational stage</label>
			  		<select name = "stage" class="form-control">
						<option value="" disabled selected>Chose Educational stage</option>
						<?php foreach ($stages as $stage): ?>

						<option  value="<?= $stage['id'] ?>"><?= $stage['name'] ?> ( <?= $stage['arabic_name'] ?> )</option>

					 	<?php endforeach ?>
					</select>
				</div>

				<div  class="form-group ">
	                <label>Chose Educational level</label>
			  		<select name = "level" class="form-control">
						<option value="" disabled selected>Chose Educational level</option>
						<?php foreach ($levels as $level): ?>

						<option  value="<?= $level['id'] ?>"><?= $level['name'] ?> ( <?= $level['arabic_name'] ?> )</option>

					 	<?php endforeach ?>
					</select>
				</div>

				<div class="form-group " >
	                <label>Chose semester</label>
			  		<select name = "semester" class="form-control">
						<option value="" disabled selected>Chose semester</option>
						<?php foreach ($semesters as $semester): ?>

						<option  value="<?= $semester['id'] ?>"><?= $semester['name'] ?> ( <?= $semester['arabic_name'] ?> )</option>

					 	<?php endforeach ?>
					</select>
				</div>
                <button type="submit" onclick="this.form.submit();this.disabled = true;"  name="add_library" class="btn blue-gradient form-control z-depth-1 p-2">Create library</button>
            </form>
                 
        </div>

    </div>

    <div class=" row ">
    	<div class="col-12   d-md-none">
    		<div class="border-top border-left border-primary ">
    			<?php include "../libraryTimeLine.php" ?>
    		</div>
    	</div>

    </div>
</div>

<?php
include "../includes/footer.php";

    
    
  
    
