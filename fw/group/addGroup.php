<?php
	include '../includes/config.php';
	

   $errors = [];
    

	if ( $_SERVER['REQUEST_METHOD']  == 'POST' ){
		
	    $group_name = filter_var ( $_POST["group-name"]  , FILTER_SANITIZE_STRING  ) ; 
    	$university_id = filter_var ( $_POST["university-id"] , FILTER_SANITIZE_NUMBER_INT  ) ;  
    	$science_field_id = filter_var ( $_POST["science-field-id"]  , FILTER_SANITIZE_NUMBER_INT  ) ;    
    	$university_name = filter_var ( $_POST["university-name"]  , FILTER_SANITIZE_STRING  ) ;   
   	 $science_field_name= filter_var ( $_POST["science-field-name"]  , FILTER_SANITIZE_STRING  ) ;  
    
		//errors
		if(empty( $group_name )){ $errors[] = "Please enter Group name";}
		
		if(empty( $science_field_name )){ $errors[] = "Please enter science field (Faculty) name";}
		
		//set it to unknown row
		if(empty( $university_name )){ $university_id = 15;}
		
		//insert new university or science_field if it isn't exist on the dropdown menu
		if( !empty( $university_name ) && empty( $university_id )){ 
			$sql = "INSERT INTO fw_university ( name , creator_id ) VALUES ( ? ,? )";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $university_name, $user_id]);
			$university_id = $pdo->lastInsertId();
		}
		if(empty( $science_field_id )){  
			$sql = "INSERT INTO fw_science_field ( name, creator_id) VALUES ( ? ,? )";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $science_field_name, $user_id]);
			$science_field_id = $pdo->lastInsertId();
		}

		if (count($errors) == 0 ) {
			
			$sql = "INSERT INTO fw_groups ( name , university, science_field  , creator_id ) VALUES ( ? ,? , ? , ? )";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $group_name , $university_id , $science_field_id , $user_id ]);
			$id = $pdo->lastInsertId();
			
			//make him admin
			$sql = "INSERT INTO fw_group_members ( user_id  , group_id , role  , status ) VALUES ( ? ,? , ? , ? )";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([ $user_id  , $id , "admin" , 1 ]);
			
       		header("location: groupProfile.php?g=" . $id);
       		exit;
    	}
	}


	//var_dump($_POST);
	include "../includes/header.php";
?>
<div class="container bg-white">

    <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fas fa-users"></i> </span>
            <h1 class =  "text-primary ">Create new group</h1>
            <small class = "text-muted">Make a group now  and invite your frinds to share and <strong> organize </strong>with each other your lectures and learning files</small>
        </div>
    </div>

    <div class=" row ">
        <div class=" col alert alert-warning p-0 m-2">
            <?php
            	foreach ($errors as $error) {
            		echo $error . "<br>";
            	}
            ?>
        </div>
    </div>

    <div class=" row  ">
        <div class=" col ">
            <form action="#" method="post"  >
            
                <div class="form-group md-form ">
                    <input type="text"  class="form-control" id = "group-name"  name = "group-name" autofocus = "true">
                    <label for = "group-name"> Group name </label>
                </div>
                
		  		<div class="form-group md-form mb-0">
                    <input type="text"  class="form-control mb-0" name = "science-field-name" value="<?= @$science_field_name ?>" id = "science-field-name" autocomplete="off" >
                    <input type="text" id = "science-field-id" = name = "science-field-id"  value="<?= @$science_field_id ?>" hidden="true" >
                    <label for = "science-field-name"> Science field ( or Faculty ) </label>
                </div>
                
                <div id = "science-field-suggestion-container" style = "overflow-y:scroll;max-height:200px"   class = " bg-white z-depth-1  "  >
                </div>

                <div class="form-group md-form mb-0">
                    <input type="text" id  = "university-name" name = "university-name" value="<?= @$university_name ?>" class="form-control mb-0" autocomplete="off" >
                    <input type="text" id = "university-id" value="<?= $university_id ?>"  name = "university-id" hidden="true" >
                    <label for = "university-name"> University name ( optional ) </label>
                </div>

                <div id = "university-suggestion-container" style = "overflow-y:scroll;max-height:200px"   class = " bg-white z-depth-1  "  >
                </div>
                
                <br>
                
                <button type="submit"  onclick="this.form.submit();this.disabled = true;"  name="add_team" value="add" class="loading  btn blue-gradient form-control z-depth-0 p-2">Create</button>
            </form>
            
            
                 
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
    
    
