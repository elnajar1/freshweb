<?php
include '../includes/config.php';

/*
echo '<pre>';
		var_dump($_POST);
echo '</pre>';
*/	
$errors = array();
	
	$name =filter_var ( $_POST['name'], FILTER_SANITIZE_STRING );
	$book_id = filter_var ($_POST['book_id'], FILTER_SANITIZE_NUMBER_INT );
	$c_section_id = filter_var ( $_POST['section_id'], FILTER_SANITIZE_NUMBER_INT );
	
	if(empty($name)){
		array_push($errors , "please enter the flolder name");
	}
	

	if(count($errors) == 0 ){
		$sql = "INSERT INTO fw_sections (name , c_section_id , book_id ,creator_id) VALUES (? , ?,? ,?) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name , $c_section_id, $book_id , $user_id]);
		
		echo '<div class = "alert alert-success m-3">
					<p> Created #! </p>
				</div>' ;
	}else{
		echo '<div class="alert alert-warning">' ;
  			 foreach($errors as $error){
   				echo  '<p>'  .  $error . '</p>' ;
   			} 	
		echo '</div>' ;
			  
	}
	


