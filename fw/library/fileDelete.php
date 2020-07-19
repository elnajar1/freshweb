<?php

include '../includes/config.php';

$book_id =  filter_var ($_POST["book_id"], FILTER_SANITIZE_NUMBER_INT );
$file_name = filter_var ($_POST["file_name"], FILTER_SANITIZE_STRING );

var_dump ( $_POST  );

if(!empty($book_id  && $file_name)){
	
	   //update into DB 
	   $sql = "Delete FROM fw_files  WHERE name  =? ";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([  $file_name ]);
	    unlink( 'files/' . $book_id . '//'  . $file_name );
	
}
