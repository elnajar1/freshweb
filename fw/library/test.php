<?php

	
	$fileToSend = "files/7/74977629.png";
	
	
	// Set headers
	/*
    header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($fileToSend) . "\""); 
readfile($fileToSend); 
	*/
	include "../includes/header.php";
	
?>
<script>

function downloadFile(url) { 
	var iframe;
	 iframe = document.getElementById("download-container"); 
	if (iframe === null) { 
		iframe = document.createElement('iframe');
	 iframe.id = "download-container";
	  //iframe.style.visibility = 'hidden'; 
	  document.body.appendChild(iframe); 
	  }
	  
	   iframe.src = url; 
	   }
downloadFile('book.php');
</script>
		<a href = "files/7/71078171.docx" > down></a>
	
<?php
include "../includes/footer.php";