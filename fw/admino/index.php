<?php
	
	include "../includes/config.php";
	include "adminServer.php";
	include "../includes/header.php";
?>
<div class = "container">

	<div class=" row ">
        	<div class=" col text-center">
           	   <span style="font-size : 2em;"> <i class="fas fa-key"></i> </span>
             	 <h1 class =  "text-primary ">Adim Page</h1>
            	 <small class = "text-muted">وقالوا علي الله توكلنا ربنا لا تجعلنا من القوم الظالمين </small>
        	</div>
        </div>
    
	<div class = "row text-center  " >
		<div class = "col-12" >
			<a href = "visits.php" class = "w-100 alert alert-info ">visits</a>
		</div>
		
		<div class = "col-12" >
			<a href = "addUniversity.php" class = "w-100 alert alert-info ">Add University</a>
		</div>
		
		<div class = "col-12  " >
			<a href = "addScience.php" class = " w-100 alert alert-info " >Add Science</a>
		</div>
		
		<div class = "col-12" >
			<a href = "addScienceField.php" class = " w-100 alert alert-info " >Add Sience Field</a>
		</div>
		
		<div class = "col-12" >
			<a href = "addStage.php" class = " w-100 alert alert-info " >Add Stage</a>
		</div>

		<div class = "col-12" >
			<a href = "addLevel.php" class = "w-100 alert alert-info " >Add Level</a>
		</div>

		<div class = "col-12" >
			<a href = "addSemester.php" class = "w-100 alert alert-info " >Add Semester</a>
		</div>

		<div class = "col-12" >
			<a href = "add.php" class = " w-100 alert alert-info " >Add</a>
		</div>
		
	</div>
</div>
<?php
include "../includes/footer.php";
//include "../../fresh_code/index.php";
    
    
    
