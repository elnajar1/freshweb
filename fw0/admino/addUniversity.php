<?php
	
	include "../includes/header.php";
	include "adminServer.php";
	
	//universitys
	$sql ="SELECT arabic_name FROM fw_university  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$unversitys = $stmt->fetchall();
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fas fa-university"></i> </span>
            <h3>Add university</h3>
        </div>
    </div>
   <div class=" row ">
        <div class=" col alert alert-success">
        	<?= $status ?>
        </div>
    </div>
    
    <div class=" row ">
        <div class=" col ">
            <form action="#" method="post">
            
                <div class="form-group md-form">
                    <label for = "a"> University name * </label>
                    <input type="text" id = "a" name = "university_name"  class="form-control">
                </div>
                
                <div class="form-group md-form">
                    <label for = "b"> Arabic name * </label>
                    <input type="text" id = "b" name = "university_arabic_name"  class="form-control">
                </div>
                
                <div class="form-group md-form">
                    <label for = "c"> Short name </label>
                    <input type="text" id = "c"  name = "university_short_name" class="form-control">
                </div>
                
                <div class="form-group md-form">
                    <label for = "d"> URL </label>
                    <input type="text" id = "d"  name = "university_url" class="form-control">
                </div>
                
                <button type="submit" name="add_university"  class="btn btn-primary btn-block p-1  form-control">ADD</button>
            </form>
        </div>
    </div>
</div>
<?php

var_dump( $unversitys );

include "../includes/footer.php";
include "../../fresh_code/index.php";
    
    
    
