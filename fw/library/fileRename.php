<?php

include '../includes/config.php';


$file_id = filter_var ( $_POST["file_id"], FILTER_SANITIZE_NUMBER_INT );
$new_custom_name = filter_var ( $_POST["new_custom_name"], FILTER_SANITIZE_STRING );

var_dump( $_POST );

if(!empty($file_id && $new_custom_name  ) && trim($new_custom_name) !== ""){
	
	   //update into DB 
	   $sql = "UPDATE fw_files SET  custom_name =? WHERE id =? ";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([  $new_custom_name, $file_id ]);
		    
}
