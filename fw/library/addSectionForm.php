		
		
<form  id = "add-section-form"  method="post" class="p-2">

	<div class = "row mb-1">
		
		<div class = "col">
			<label>folder ( Lecture ) name : </label>
			<input type="text" name = "name" placeholder = "Lecture name" class = " form-control " required="true">
			<input type="text" value = "<?= $_POST['section_id' ] ?>" name = "section_id" placeholder = "name" class = " form-control" hidden>
			<input type="text" value = "<?= $_POST['book_id'] ?>" name = "book_id"  class = " form-control" hidden>
		</div>
	</div>

	<div class = "row">
	
		<div class = "col">
			<input type="submit"  id = "add-section-submit-button"  name = "add-section" value="Add" class ="btn btn-success btn-block btn-sm m-0 " />
		</div>
		
		<div class = "col ">
			<span class  =  "add-section-hide btn btn-danger  btn-block btn-sm m-0 " >close </span>
		</div>
		
</form>

		
		
	</div>
	


<?php 
/*
echo '<pre>';
		var_dump($_POST);
echo '</pre>';
*/	

?>
<!-- library  js -->
<script src="/fw/layout/library/js/main.js"></script>


  

    
    