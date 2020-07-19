<?php
    
	include "../includes/header.php";
	include "adminServer.php";
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fas fa-flag"></i> </span>
            <h3>Add new science field</h3>
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
                    <label for = "a"> Science Field name * </label>
                    <input type="text" id = "a" name = "science_field_name"  class="form-control">
                </div>
                
                <button type="submit" name="add_science_field" value="add" class="btn btn-primary btn-block p-1  form-control">ADD</button>
            </form>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
include "../../fresh_code/index.php";
    
    
    
