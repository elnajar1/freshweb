<?php

include '../includes/config.php';


$file_id = filter_var ( $_POST["file_id"], FILTER_SANITIZE_NUMBER_INT );
$author_name = filter_var ( $_POST["author_name"], FILTER_SANITIZE_STRING );

var_dump( $_POST );

if(!empty($file_id && $author_name  ) && trim($author_name) !== ""){
	
	   //update into DB 
	   $sql = "UPDATE fw_files SET  author =? WHERE id =? ";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([  $author_name , $file_id ]);
		    
}
