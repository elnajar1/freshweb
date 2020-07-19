<?php
	
	include "../includes/header.php";
	include "adminServer.php";
	
	//stages
	$sql ="SELECT *FROM fw_edu_stage  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$stages = $stmt->fetchall();
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <h3>Add Stsge</h3>
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
                    <label for = "a">Stage name * </label>
                    <input type="text" id = "a" name = "stage_name"  class="form-control" autofocus = "true">
                </div>
                
                <div class="form-group md-form">
                    <label for = "b"> Arabic name * </label>
                    <input type="text" id = "b" name = "stage_arabic_name"  class="form-control">
                </div>
                
                <button type="submit" name="add_stage"  class="btn btn-primary btn-block p-1  form-control">ADD</button>
            </form>
        </div>
    </div>
</div>

<pre>
<?php

var_dump( $stages );

include "../includes/footer.php";
//nclude "../../fresh_code/index.php";
    
    
    
