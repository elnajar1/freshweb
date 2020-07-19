<?php
	
	include "../includes/header.php";
	include "adminServer.php";
	
	//semesters
	$sql ="SELECT *FROM fw_edu_semester  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$semesters = $stmt->fetchall();
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <h3>Add Semester</h3>
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
                    <label for = "a">semester name * </label>
                    <input type="text" id = "a" name = "semester_name"  class="form-control" autofocus = "true">
                </div>
                
                <div class="form-group md-form">
                    <label for = "b"> semester Arabic name * </label>
                    <input type="text" id = "b" name = "semester_arabic_name"  class="form-control">
                </div>
                
                <button type="submit" name="add_semester"  class="btn btn-primary btn-block p-1  form-control">ADD</button>
            </form>
        </div>
    </div>
</div>

<pre>
<?php

var_dump( $semesters );

include "../includes/footer.php";
include "../../fresh_code/index.php";
    
    
    
