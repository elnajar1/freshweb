<?php

include '../includes/config.php';


$section_id = filter_var ( $_POST['section_id' ], FILTER_SANITIZE_NUMBER_INT );
$new_section_name = filter_var ( $_POST["section_name"], FILTER_SANITIZE_STRING );

var_dump( $_POST );

if(!empty( $section_id && $new_section_name  ) && trim($new_section_name) !== ""){
	
	   //update into DB 
	   $sql = "UPDATE fw_sections SET  name =? WHERE id =? ";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([  $new_section_name, $section_id ]);
		    
}
