<?php
include '../includes/config.php';

$book_id =  filter_var ($_POST['book_id'], FILTER_SANITIZE_NUMBER_INT );
$file_id =  filter_var ($_POST['file_id'], FILTER_SANITIZE_NUMBER_INT );

		//sections
	$sql ="SELECT * FROM fw_sections WHERE  book_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$book_id ]);
	$sections = $stmt->fetchall();
	//var_dump ( $sections) ;
?>
	
<form  id = "move-file-form"  method="post" class="p-2">

	<div class = "row mb-1">
		
		<div class = "col">
			<label>Select  folder to move file to : </label>
			<select name = "new_c_section_id" class = " form-control">
				<?php foreach($sections as $section ): ?>
					<option value ="<?= $section['id'] ?>" > <?= $section['name'] ?> </option>
				<?php endforeach; ?>
			</select>
			<input type="text" value = "<?= $file_id ?>" name = "file_id"  class = " form-control" hidden>
			<input type="text" value = "<?= $book_id ?>" name = "book_id"  class = " form-control" hidden>
		</div>
	</div>

	<div class = "row">
	
		<div class = "col">
			<input type="submit"  id = "move-submit-button" name = "file-move" value="move" class ="btn btn-success btn-block btn-sm m-0 " />
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


  

    
    
