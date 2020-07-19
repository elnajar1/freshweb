<?php
	include "../includes/header.php";
	include "adminServer.php";
?>
<div class="container">

    <div class=" row ">
        <div class=" col text-center">
            <span style="font-size : 2em;"> <i class="fas fa-flask"></i> </span>
            <h1>Add new science</h1>
        </div>
    </div>

    <div class=" row ">
        <div class=" col ">
            <form action="#" method="post">
                <div class="form-group">
                    <label> Science name </label>
                    <input type="text" placeholder=" name  " class="form-control">
                </div>
                
		  <div class="form-group">
                    <label> Science Field </label>
                    <select name="" class="form-control">
                        <option value=""> Midiciene </option>
                    </select>
                </div>
                
                <input type="submit" name="add_team" value="add" class="btn btn-primary form-control">
            </form>
        </div>
    </div>
</div>
<?php
include "../includes/footer.php";
include "../../fresh_code/index.php";
    
    
    
