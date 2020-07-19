<?php
	//main.js included at the end of file #! 
	//config.php included in function.php
	include '../includes/functions.php';
	
	$c_section_id = filter_var ($_POST['sectionId'], FILTER_SANITIZE_NUMBER_INT );
	$book_id = filter_var ($_POST['book_id'], FILTER_SANITIZE_NUMBER_INT );
	$role = filter_var ($_POST['role'], FILTER_SANITIZE_STRING );
	/*
	if(empty($c_section_id)){
		$c_section_id = "0"; 
	}
	*/
		
	//$auther_name = "";


	
	//sections
	$sql ="SELECT * FROM fw_sections WHERE c_section_id = ? AND book_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$c_section_id , $book_id]);
	$sections = $stmt->fetchall();
	
	//current section info 
	$sql ="SELECT * FROM fw_sections WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$c_section_id]);
	$this_section = $stmt->fetch();

	//visits analysis 
	$ip = $_SERVER['REMOTE_ADDR']; 
	$page = basename($_SERVER['PHP_SELF']);
	$url =$_SERVER['REQUEST_URI'];  
	
	$sql = "INSERT INTO fw_visits ( user_id, ip, page, url, host ) VALUES (?,?,?,?,? )";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id , $ip , $this_section['name'], $url, $domain]);

	
	//var_dump($sections);
	//files
	$sql ="SELECT f.* , fw_users.name, fw_users.fb_name, 
		 DATEDIFF(NOW(), f.time) AS 'days' 
		 FROM fw_files f
		 LEFT JOIN fw_users  ON f.uploader_id = fw_users.id
		WHERE c_section_id = ? AND book_id = ? 
		ORDER BY id DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$c_section_id , $book_id]);
	$files = $stmt->fetchall();
	//echo "<pre>";
	//print_r($files);
	//echo "</pre>";
	
	function section_options( $role, $section_id, $section_name ) {
		 if( ( $role  == "member"  || $role  == "admin" ) ) : 
		?> 
		<div class="dropdown dropright d-inline-block "> 
			<button class="btn bg-white p-1 m-0 z-depth-0 " type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 		<i class="text-muted fa fa-ellipsis-v"></i> 
			 </button> 
		 	<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
				
		 		<button id = "<?= $section_id ?>" value = "<?= $section_name  ?>"  class="rename-section dropdown-item" type="button">
				 	<i class="text-muted fas fa-highlighter"></i> Rename folder
				</button> 
				
		 	</div> 
		 </div>
		
		<?php
		endif;
	}
	
	function file_options( $role, $file_id, $file_name, $book_id ) {
		 if( ( $role  == "member"  || $role  == "admin" ) ) : 
		?> 
		<div class="dropdown dropright d-inline-block "> 
			<button class="btn bg-white p-1 m-0 z-depth-0 " type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 		<i class="text-muted fa fa-ellipsis-h"></i> 
			 </button> 
		 	<div class="dropdown-menu " aria-labelledby="dropdownMenu2">
				
		 		<button id = "<?= $file_id ?>" class="rename-file dropdown-item" type="button">
				 	<i class="text-muted fas fa-highlighter"></i> Rename file
				</button> 
				
				<button id = "<?= $file_id ?>" class="rename-file-author dropdown-item" type="button">
				 	<i class="text-muted fas fa-user"></i> Rename autor
				</button> 
				
				<button id = "<?= $file_id ?>" value  = "<?= $book_id ?>" class="move-file pl-2 dropdown-item" type="button">
				 	<i class="fas fa-arrow-left text-muted  "> 
					 </i><i class="text-muted far fa-folder"></i> 
					 move 
				</button> 
				
				<?php if( $role  == "admin" ) : ?>
				 <button id = "<?= $file_id  ?>"  value = "<?= $book_id  ?>" name = "<?= $file_name ?>" class="delete-file dropdown-item" type="button">
					<i class="text-muted fas fa-trash-alt"></i> Delete
				</button> 
				
				<?php else: ?>
					
				<button  class="bg-light text-muted dropdown-item"  disabled  >
					<i class="text-muted  fas fa-trash-alt"></i> Delete (admin only)
				</button> 
		 		<?php endif ; ?>
			
		 	</div> 
		 </div>
		
		<?php
		endif;
	}
	
	
	
?>

<style>


.files p{
	white-space: nowrap;
       overflow: hidden !important;
       text-overflow: ellipsis;
	max-width :85%;
}
.card p{
	white-space: nowrap;
       overflow: visible !important;
       text-overflow: ellipsis;
	max-width :60%;
}
</style>
<div class = "container-fluid ">
	
	<!-- sections -->
	<div class = "row">	
	
		<div class = "col" >
        	
			<?php foreach( $sections as $s ){  ?>
				
			<button class ="btn btn-white  btn-block btn-sm mt-1    show-section-content" id = "<?= $s['id'] ?>" >
				<i class="far fa-folder"></i>   
				<?= substr(htmlspecialchars($s['name' ]) , 0, 50) ?>  
			</button>
			
			<?php
					/*
        			<button value = "<?= $s['id'] ?>"  id = "add-section-<?= $s['id'] ?>" style = "display : none ;font-size : 8px; "  class = "add-section text-dark border border-light border-top-0 btn  btn-sm  text-dark m-0  z-depth-0 ">
					 Add New folder
        			</button>
        			*/
        		?>
        		<div id = "section-<?= $s['id'] ?>" class = " border-left border-white bg-dark">
        		</div>
        			
        		<?php } ?>
        			
		</div>
		
	</div><!--/ sections -->
	
	<!-- menu and uploud -->
	<div class = "row">
			
		<div class = "col-5">
			<p class = "text-muted border-bottom">Files</p>
		</div>
		
		<div class = "col w-100 text-right">
		<?php 
			if (empty($user_id )):
			 	echo '<button  class = "show-sing-in-advise z-depth-0  btn  btn-sm p-2    rounded border border-white bg-dark "><i class="fa fa-cloud-upload-alt "> upload </i> </button>' ;
			
			elseif( $role ==  "member"  || $role ==  "admin" ):
		?>
			<div>
				<form class = "file-upload-form-<?= $c_section_id ?> file-upload-form" action = "#"  method="post" enctype="multipart/form-data">
					<input name="c_section_id" value =  "<?= $c_section_id ?>" type="text" hidden/>
					<input name="book_id" value =  "<?= $book_id ?>" type="text" hidden/>
					<input hidden ="true" class ="file-upload file-upload-<?= $c_section_id ?>"  name="file_upload[]" type="file" multiple />
   	 			   <input hidden= "true" type="submit"  name="file_upload" />
   				   <small>
   				 	 <button  id = "<?= $c_section_id ?>" class = " btn-upload btn  btn-sm p-2    rounded border border-white bg-dark "><i class="fa fa-cloud-upload-alt "> upload </i> </button>
					</small>
				</form>
				<div style = "display :none"class=" progress-<?= $c_section_id ?> progress-bar-div-<?= $c_section_id ?> my-progress borde bg-info rounded ">
 					 <div class="progress-bar progress-bar-<?= $c_section_id ?>  progress-bar-striped active " role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0</div>
				</div>
				<div id="data-<?= $c_section_id ?>">
				</div>
			</div>
		
		
		<?php 
			else :
				echo '<a href = "#group-info" class = " z-depth-0  btn  btn-sm p-2    rounded border border-white bg-dark "><i class="fa fa-cloud-upload-alt "> upload </i> </a>' ;
			endif;
		
		
		?>
		</div>
		
		<div class = "col-1 py-2 ">
		
			<?php section_options( $role, $c_section_id , $this_section['name'] ); ?>
		
		</div>
	</div><!--/ menu and upload  -->
	
	<?php
		if(count($files) == 0 ){
			echo '<small class = "  text-info">No files here, please upload ! </small>' ;
			echo '<hr class = "m-0 p-0 ">' ;
		}else{
			
	?>
	
	<!-- files -->
	 <div class = "row border-bottom pr-2 files">	
		
		<?php
			 foreach( $files as $f ):
			
				if( $f['type' ] == "video"   ):
					$path  = 'files/' . $book_id . '/' . $f[2];
					if(file_exists('files/' . $book_id . '/' . $f[2] )):
						
		?>
			
			<!-- video -->
			<div class = "col-12 m-1  bg-white z-depth-1 rounded ">
					
				<div class = "row" >
						
					<div class = "col">
					
					<?php
							echo '<p class = "d-inline-block text-primary"><span id = "name-' .  $f['id'] . '" >' . substr(htmlspecialchars($f['custom_name' ]) , 0, 200)  . '</span>' ;
								echo '<div class = "d-inline-block float-right">' ;
									file_options( $role, $f['id'], $f[2], $book_id );
								echo '</div>' ;
							echo '</p>' ;
							
							echo '<video controls preload="true" class ="my-1  d-block m-auto" style = "max-width:100%;max-height:250px;"><source src="' . 'files/' . $book_id . '/' . $f[2] . '">please update your browser </video>' ;
							
						?>
							
						<small  class = "d-block text-muted">
							<i class="text-muted fas fa-user"></i> Author : 
							<span  id = "author-name-<?= $f['id'] ?>" >
							<?php 
								echo substr($f['author' ],0,100);
								
								 if( empty( $f['author' ] ) ):
								
									 echo substr($f['fb_name' ],0,100); 
									
										if( empty( $f['fb_name' ] ) ):
										 	echo substr($f['name' ],0,100); 
										endif;  
								
								endif;  
								
								
							?> 
							</span>
						</small>
						
						<?php love_post( $f['id'] ); ?>
							
						. 
						
						<a href ="download.php?file=<?= 'files/' . $book_id . '/' . $f[2] ?>&section_name=<?=  $this_section['name'] ?>&file_custom_name=<?=  $f['custom_name'] ?>" ><span><i class = "fa fa-download"></i></span></a>
						. 
						 
						<small class ="share" id = "<?= $domain .  $root . '/library/book.php?b=' . $f['book_id'] . '&f=' . $f['id']  ?>">
							<span class = "text-primary "><i class = "fa fa-share"></i></span> 
						</small>
						
						. 
						
						<small>
							 <span class = "text-muted dots"><?php if ($f['days'] == 0 ): echo 'Today' ; else: echo $f['days'] . ' days ago' ; endif; ?> </span>
						</small>
						
						<small class = "float-right text-muted" >
							<?= FileSizeConvert(filesize($path)); ?>
						</small>
						
					</div>
						
				</div>
						
			</div><!--/video -->
			
		<?php
			
					else :
					
						//echo '<span style="font-size: 3em;color:gray"><i class="fas fa-exclamation-triangle m-3"></i></span>' ;
						
					endif;
				endif;
			endforeach;
		?>
		
		<?php
			 foreach( $files as $f ):
				$path  = 'files/' . $book_id . '/' . $f[2];
				if( $f['type' ]== "doc"   ||  $f['type' ]== "audio" ):
					if(file_exists('files/' . $book_id . '/' . $f[2] )):
		?>
			
			<!-- docs -->
			<div class = "col-12 m-1  bg-white z-depth-1 rounded ">
					
				<div class = "row" >
						
					<div class = "col">
					
					<?php
							 if ($f['type'] == "doc"):
								
								echo '<p class = "d-block text-primary">' ;
								echo '<p class = "d-inline-block text-primary"><span class ="d-inline-block  text-primary "><i class = " fa fa-file-alt"></i></span> <span id = "name-' .  $f['id'] . '"  >'  . substr(htmlspecialchars($f['custom_name' ]) , 0, 200 ) . '</span>' ;
								echo '<div class = "d-inline-block float-right">' ;
									file_options( $role, $f['id'], $f[2], $book_id );
								echo '</div>' ;
								echo '</p>' ;
								
							elseif ($f['type']   == "audio"):
								echo '<p class = "d-block text-muted">' ;
								echo '<p class = "d-inline-block text-primary"><span class ="d-inline-block  text-primary "><i class = " fa fa-music"></i></span> <span id = "name-' .  $f['id'] . '"  >'  . substr(htmlspecialchars($f['custom_name' ]) , 0, 200 ) . '</span>' ;
								echo '<div class = "d-inline-block float-right">' ;
									file_options( $role, $f['id'], $f[2], $book_id );
								echo '</div>' ;
								echo '</p>' ;
								echo '<audio controls preload="true"  class ="my-1" style = "max-width:100%"><source src="' . $domain .  $root . '/library/files/' . $book_id . '/' . $f[2] . '"type="audio/';
								
								if ( substr ( $f[2],-3) ==  'mp3' ):
									echo 'mpeg' ;
								else:
									echo 'mp4' ;
								endif;
								
								echo  '">please update your browser </audio></span>' ;
															

endif;
						?>
							
						<small  class = "d-block text-muted">
							<i class="text-muted fas fa-user"></i> Author : 
							<span  id = "author-name-<?= $f['id'] ?>" >
							<?php 
								echo substr($f['author' ],0,100);
								
								 if( empty( $f['author' ] ) ):
								
									 echo substr($f['fb_name' ],0,100); 
									
										if( empty( $f['fb_name' ] ) ):
										 	echo substr($f['name' ],0,100); 
										endif;  
								
								endif;  
								
								
							?> 
							</span>
						</small>
					
						<?php
							 if ($f['type'] == "doc"):
							
					  		 echo '<a  class = "text-right" href ="' . $root . '/library/files/' . $book_id  . '/' . $f[2]  .  '" ><span class =" m-auto " style="font-size: 0.8em;"><i class = " fa fa-external-link-alt"></i></span>  </a> . ' ;
							
							endif;
						?>
						
						<?php love_post( $f['id'] ); ?>
							
						. 
						
						<a href ="download.php?file=<?= 'files/' . $book_id . '/' . $f[2] ?>&section_name=<?=  $this_section['name'] ?>&file_custom_name=<?=  $f['custom_name'] ?>" ><span><i class = "fa fa-download"></i></span></a>
						. 
						
						<span class ="share text-primary" id = "<?= $domain .  $root . '/library/book.php?b=' . $f['book_id'] . '&f=' . $f['id']  ?>">
							<span class = "text-primary "><i class = "fa fa-share"></i></span> Share
						</span>
						
						. 
						
						<small class = " d-inline-block">
							 <span style = "font-size:10px" class = "text-muted"><?php if ($f['days'] == 0 ): echo 'Today' ; else: echo $f['days'] . ' days ago' ; endif; ?> </span>
						</small>
						
						<small class = "float-right text-muted" >
							<?= FileSizeConvert(filesize($path)); ?>
						</small>
						
					</div>
						
				</div>
						
			</div><!--/docs and audios  -->
			
		<?php
			
					else :
					
						//echo '<span style="font-size: 3em;color:gray"><i class="fas fa-exclamation-triangle m-3"></i></span>' ;
						
					endif;
				endif;
			endforeach;
		?>
				
		<div class = "col " >
			
			<!-- photos -->
			<div class = "row ">
			
				<?php foreach( $files as $f ){
					if( $f['type' ]== "img" ){
					 ?>
					 <div  class = "col-6  p-1">
						<?php
							echo '<div  class = "z-depth-3 bg-white d-block text-primary">' ;
									file_options( $role, $f['id'], $f[2], $book_id ); 
									
									echo '<small><span id = "name-' .  $f['id'] . '"  >' . substr($f['custom_name'], 0,15) . '</span></small>' ;
							echo '</div>' ;
						 ?>
						 <div  style = "border-radius: 0px"  class = "card  w-100  library-card  d-inline-block">
						<?php 
							if(file_exists('files/' . $book_id . '/' . $f[2] )):
								
								echo '<img  class = " card-img-top library-card-img-top " alt = "';   if ($f['days'] == 0 ): echo 'Today' ; else: echo $f['days']  . ' days ago' ; endif;   echo  ' . '  . $f['custom_name'] . '" id="myImg" src="files/' . $book_id . '/' . $f[2]  .  '" />' ;
								
							else :
								//echo '<span class = "card-img-top" style="font-size: 3em;color:gray"><i class="fas fa-exclamation-triangle m-3"></i></span>' ;
							endif;
						?>
						<div class = "card-body library-card-body p-0">
							<p class = "card-text w-100">
								
								<?php love_post( $f['id'] ); ?>
								
								. 
								
								<a href ="download.php?file=<?= 'files/' . $book_id . '/' . $f[2] ?>&section_name=<?=  $this_section['name'] ?>&file_custom_name=<?=  $f['custom_name'] ?>" ><span><i class = "fa fa-download"></i></span></a>
								 . 
							
								<small class ="share" id = "<?= $domain .  $root . '/library/book.php?b=' . $f['book_id'] . '&f=' . $f['id']  ?>">
									<span class = "text-primary "><i class = "fa fa-share"></i></span> 
								</small>
							
								<small  class = " text-muted">
										<span  id = "author-name-<?= $f['id'] ?>" >
										<?php 
											echo substr($f['author' ],0,144);
								
											 if( empty( $f['author' ] ) ):
								
												 echo substr($f['fb_name' ],0,144); 
												
												if( empty( $f['fb_name' ] ) ):
												 echo substr($f['name' ],0,144); 
												endif;  
								
											endif;  
								
								
								?> 
								</span>
							</small>
							
							
							</p>
							
						</div>
						
						
							
					</div>
				</div>
				<?php
					}
				} 
				 ?>
		 
			</div><!--/photos -->
			
		</div>
		
	</div><!-- /files -->
	
	<?php
		} //end if - > else 
	?>
	
</div><!-- container -->

<!-- library  js -->
<script src="../layout/library/js/main.js"></script>
    
    
    
    
    
    
    
    
