<?php
	
	include "../includes/header.php";
	include "adminServer.php";
	
	//levels
	$sql ="SELECT *FROM fw_edu_level  ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$levels = $stmt->fetchall();
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <h3>Add level</h3>
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
                    <label for = "a">level name * </label>
                    <input type="text" id = "a" name = "level_name"  class="form-control" autofocus = "true">
                </div>
                
                <div class="form-group md-form">
                    <label for = "b"> level Arabic name * </label>
                    <input type="text" id = "b" name = "level_arabic_name"  class="form-control">
                </div>
                
                <button type="submit" name="add_level"  class="btn btn-primary btn-block p-1  form-control">ADD</button>
            </form>
        </div>
    </div>
</div>

<pre>
<?php

var_dump( $levels );

include "../includes/footer.php";
include "../../fresh_code/index.php";
    
    
    
