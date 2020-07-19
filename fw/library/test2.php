<?php
$c_section_id = $_POST["c_section_id"];
?>
<div>
	<form action = "lecUpload.php"  method="post" enctype="multipart/form-data">
		<input id="upload" name="c_section_id" value =  "<?= $c_section_id ?>" type="text"/>
		<input id="upload" name="file_upload[]" type="file" multiple />
   	    <input type="submit" name="file_upload" />
	</form>
</div>


<!-- library  js -->
<script src="/fw/layout/library/js/main.js"></script>
    
    
