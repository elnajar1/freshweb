<?php

include '../includes/config.php';


$file_id = filter_var ( $_POST["file_id"], FILTER_SANITIZE_NUMBER_INT );
$new_c_section_id = filter_var ( $_POST["new_c_section_id"], FILTER_SANITIZE_STRING );

var_dump( $_POST );

if(!empty($file_id && $new_c_section_id  )){
	
	   //update into DB 
	   $sql = "UPDATE fw_files SET  c_section_id =? WHERE id =? ";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([  $new_c_section_id, $file_id ]);
		    
}

?>
<div class = "alert alert-success">
	<p> Moved #! </p>
</div>
   
<script>
	$("#name-"  +  "<?= $file_id ?>" ).parent().parent().parent().hide("slow");
	setTimeout(function(){
		document.getElementById("<?= $new_c_section_id ?>").click();
		$("#name-"  +  "<?= $file_id ?>" ).parent().parent().parent().remove();
	
	}, 1000);

</script>




