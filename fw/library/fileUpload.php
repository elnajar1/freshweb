<?php

include '../includes/config.php';

echo "<hr>";

/*
echo ini_get("post_max_size") .  "<br>"; 
echo ini_get("upload_max_filesize") .  "<br>"; 
echo ini_get("max_input_time") . "<br>"; 
echo ini_get("max_execution_time");
*/
	
//var_dump($_POST);

$book_id = filter_var ($_POST["book_id"], FILTER_SANITIZE_NUMBER_INT );
$errors = array();
$number = 1;

//come from the upload form 
$param = "file_upload";

if(isset($_FILES[ $param ])){
	
	//group of images name
	//$custom_name = $_POST['custom_name'];
	
	$c_section_id = filter_var ($_POST['c_section_id'], FILTER_SANITIZE_NUMBER_INT );
	
	//arrays needed #! 
	$fileName = $_FILES[ $param ]['name'] ;
	$fileSize = $_FILES[ $param ]['size'];
	$fileTmp = $_FILES[ $param ]['tmp_name'];
	$fileError = $_FILES[ $param ]['error'];
	
	//check dirs
  	  if(!is_dir('files')){
  	 	 mkdir('files');
  	 	 chmod('files'  , 0755);
            }
            
  	   if(!is_dir('files/' . $book_id )){
   		 mkdir('files/' . $book_id );
   		 chmod('files/' . $book_id , 0755);
   	} 
   	
      for($i = 0 ; $i < count($fileName) ; $i++ ){
      	
           $imgTypes = array("png" , "jpg" , "jpeg", "gif");
	    $docTypes = array("docx" , "doc", "xls", "xlsx",   "ppt", "pptx", "pdf", "txt");
	    $audioTypes = array("3ga", "aac", "aiff", "amr", "ape", "arf", "asf", "asx", "cda" , "dvf", "flac", "gp4", "gp5", "gpx", "logic", "m4a", "m4b", "m4p", "midi", "mp3", "ogg", "opus", "pcm", "rec", "snd", "sng", "uax", "wav", "wma", "wpl", "zab");
	    $videoTypes = array('mov', 'mpeg4', 'mp4', 'avi', 'wmv', 'mpegps', 'flv', '3gpp', '3gp','mebm', 'dnxhr', 'prores', 'cineform', 'hevc' );
	  	     
    	//lecExtension security
   	 $accepted_types = array_merge( $imgTypes , $docTypes , $audioTypes , $videoTypes );
    	$fileNameArray = explode("." , $fileName[$i]);
    	$fileExtension = strtolower(end( $fileNameArray ));
    
  	    //push errors
    	  if(!in_array($fileExtension , $accepted_types)){
			array_push($errors , "file type(" . $fileExtension . ")is not supported, or file named in wrong way. images, documents, audios and videos are supported ");
	      }
	
      
		if(empty( $fileName[$i] )  ||  $fileError[$i]  == 4 ){
			array_push($errors , "please choose a file frist");
		}
	
	
	
		if($fileSize[$i]  > 143400320 ){
			array_push($errors , "file size is so larg ,please chose a file less than 140 MB");
		}
	
		//for developers only
		/*
		if( $fileError[$i] > 0  ){
			array_push($errors , $fileName[$i]  .   "error No : " . $fileError[$i]  .  "");
			echo '<pre>';
			var_dump($_POST);
			var_dump($_FILES);
			echo '</pre>';
		}
		*/
			
		if(count($errors) == 0 ){
		
			
	     	 //what's the uplouded file type (img , video , sound ,pdf)
    		  if(in_array($fileExtension , $imgTypes )){
    	 		$fileType = "img";
    	 	 }
    	 
    	 	  if(in_array($fileExtension , $docTypes )){
    			 $fileType = "doc";
    		  }
    		  
    		  if(in_array($fileExtension , $audioTypes )){
    			 $fileType = "audio";
    		  }
    		  
    		   if(in_array($fileExtension , $videoTypes )){
    			 $fileType = "video";
    		  }
  	 
  		  //upload
   	  	$newFileName = rand(0 , mt_getrandmax() )  .  '.' .  $fileExtension;
    		 move_uploaded_file($fileTmp[$i] ,  'files/' . $book_id . '//'  . $newFileName );
	   	
	   	  //custom_name
     		$custom_name = $fileName[$i] ;
	   	  
	   	 //insert into DB 
	   	 $sql = "INSERT INTO fw_files (name , custom_name , c_section_id , type ,uploader_id, book_id) VALUES (? , ? ,? ,? ,?,? ) ";
	   	 $stmt = $pdo->prepare($sql);
	   	 $stmt->execute([$newFileName , $custom_name , $c_section_id , $fileType , $user_id , $book_id]);
		    
		    
		    echo '<div class="alert alert-success py-1">' ;
   			echo  '<small>' .   $number  . '-uploaded  #! </small>' ;
		    echo '</div>' ;
		    $number++;
		    echo '<script>' ;
		    
		    echo  'setTimeout(function(){' ;
	
		    echo 'document.getElementById("'. $c_section_id . '").click();' ;
  		  
  		  echo  '}, 1000);' ;
		  
		    echo '</script>' ;
			
		}else{
			echo '<script>alert("' ;
			
  			 foreach($errors as $error){
   				echo  ''  .  $error . ' . ' ;
   			} 	
			echo '");</script>' ;
		}
	
    }
    
	
}

