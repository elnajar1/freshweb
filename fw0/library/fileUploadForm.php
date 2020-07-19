<?php
$c_section_id = filter_var( $_POST["c_section_id"], FILTER_SANITIZE_NUMBER_INT );
$book_id = filter_var ( $_POST["book_id"], FILTER_SANITIZE_NUMBER_INT );
include "../includes/header.php";
?>

<div>
	<form id = "file-upload-form" action = "#"  method="post" enctype="multipart/form-data">
		<input name="c_section_id" value =  "<?= $c_section_id ?>" type="text"/>
		<input name="book_id" value =  "<?= $book_id ?>" type="text"/>
		<input hidden ="true" id="file-upload"  name="file_upload[]" type="file" multiple />
   	    <input hidden= "true" type="submit"  name="file_upload" />
   	    <button id="btn-upload">upload</button>
	</form>
	<div class="progress">
 		 <div class="progress-bar progress-bar-striped active" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0</div>
	</div>
	<div id="data">
	</div>
</div>


<?php
include "../includes/footer.php";
