<?php


include "config.php";


//file size
function FileSizeConvert($bytes){
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

function is_loved($file_id ){
	
	$ip  =  $GLOBALS['ip'];
	global $user_id;
	global $pdo;
	
	if(!empty($user_id) ){
		
		$stmt =  $pdo->prepare('SELECT id  FROM fw_file_love WHERE file_id = ? AND user_id = ? ');
 		$stmt->execute([$file_id, $user_id]);
 		$count_love = $stmt->rowCount();
 		
 		if( $count_love > 0 ){
 			return true;
 		}
 		
	}else{
		
		$stmt = $pdo->prepare('SELECT id  FROM fw_file_love WHERE file_id = ?  AND  ip = ?');
 		$stmt->execute([$file_id ,$ip]);
 		$count_love = $stmt->rowCount();
 		
 		if( $count_love > 0 ){
 			return true;
 		}
 		
	}
	
}

function love_post( $file_id ){
	
	 global $pdo;
	 $stmt = $pdo->prepare('SELECT id  FROM fw_file_love WHERE file_id =  ?');
 	$stmt->execute([$file_id ]);
 	$count_love = $stmt->rowCount();
 		
	 echo  ' <span class ="text-muted file-love-count-' .  $file_id  .  '">'  . $count_love . ' </span>' ;
	 
	 if( is_loved( $file_id  )  == true ):
	 
		echo '<span><i class = "fas fa-heart text-danger animate heartBeat delay-1s"></i></span>' ;
	  
	 else:  
				
		echo '<span id ="' . $file_id  .  '" class = " file-love  file-love-' .  $file_id  .  '"  ><i class = "far fa-heart"></i></span>';
					
	 endif; 
	 
	
}

						
function get_posts ( $files ){
	
	$root  =  $GLOBALS['root'];
	$domain  =  $GLOBALS['domain'];
	//var_dump ($files);
	foreach( $files as $f ): ?>
	
	<!-- post -->
	<div style = " overflow:hidden ; background: rgb(2,0,6);" class = "row   my-2">
		<div  class = "col bg-white mb-2 pb-2  border  z-depth-1 ">
		
			<div class = "row ">
				<div class = "col-2 p-2">
				
					<img style = "max-height:40px" src = "
						<?php 
							if(isset($f['avatar'])){
								echo $root . "/uploads/avatars/" . $f['avatar'];
								
								
							}else{
								echo  $f['fb_avatar'];
							}
						?>
					" class = "rounded img-fluid d-block m-auto" onerror="this.src='/fw/uploads/avatars/user.jpeg';">
					
				</div>
					
				<div class = "col p-0">
					<a href  = "<?= $root . '/user/profile.php?u=' . $f['user_id'] ?>" class = "text-dark font-weight-bold ">
						 <?php
							if(isset($f['user_name'])){
								echo $f['user_name'] ;
							}else{
								echo $f['fb_name'] ;
							}	
						?>
					</a>
					<?php
						if(isset($f['group_name'])){
							
							echo   '<a href  = "' . $root .  '/group/groupProfile.php?g=' . $f['group_id']  . '" class = " ">';
							 echo ' @ '  . $f['group_name'] ;
							echo '</a>' ;
						}	
					?>
						 
					<small class = "d-block ">
						 <span class = "text-muted"><?php if ($f['days'] == 0 ): echo 'Today' ; else: echo $f['days'] . ' days ago' ; endif; ?> </span>
					</small>
				</div>
			</div>
				
			<div class = "row ">
				<div class = "col">
					<p class = " font-weight-light" >  
						<?=  '<b> <span style = "color : gray;" ><i class = "fa fa-book"></i></span> ' . $f['science_name'] . ' </b>: '  .   '  <span  style = "color : gray" ><i class = "fa fa-folder"></i></span>   ' . $f['section_name']  .  ' <br><b class = "text-primary ">Name: </b>' .  substr($f['custom_name'], 0, 200) ?>
					</p>
					
					<div>
						<?php 
							if($f['type']  == "img"):
							
								echo '<img  style = "max-height:350px;" class = "img-fluid d-block m-auto" alt = "' . $f['time']  . '" src="' . $root . '/library/files/' . $f['book_id']  . '/' . $f['file_name']  .  '" />' ;
							
							elseif($f['type']  == "doc"):
								
								echo '<div class = "  m-2 p-2 border rounded "><a href ="' . $domain . $root . '/library/files/' . $f['book_id']  . '/' . $f['file_name']  .  '" ><span class =" m-auto " style="font-size: 1em;"><i class = " fa fa-external-link-alt"></i></span>   open   the Document file </a></div>' ;
								
							elseif($f['type']  == "audio"):
							
								echo '<span class ="myaudio"> <audio controls preload="true"  class =" my-1" style = "max-width:100%"><source src="' . $domain . $root . '/library/files/' . $f['book_id']  . '/' . $f['file_name']  .  '" type="audio/';
								
								if ( substr ( $f['file_name'],-3) ==  'mp3' ):
									echo 'mpeg' ;
								else:
									echo 'mp4' ;
								endif;
								
								echo  '">please update your browser </audio></span>' ;
								
							elseif($f['type']  == "video"):
								
								echo '<video controls   class=" video-js my-1 d-block m-auto" style = "max-width:100%;max-height:250px;" data-setup="{}"><source src="' . $root . '/library/files/' . $f['book_id']  . '/' . $f['file_name']  .  '">please update your browser </video>' ;
							
							endif;
						?>
					</div>
					
				</div>
			</div>
			
			<div class = "row ">
				<div class = "col">
			
					<?php if (!empty( $f['author']  )): ?>
						<small  class = "d-block text-muted">
							<i class="text-muted fas fa-user"></i> Author : 
							<span  id = "author-name-<?= $f['id'] ?>" >
							<?= substr($f['author' ],0,100); ?>
							</span>
						</small>		 
					<?php endif;  ?> 
						
				</div>
			</div>
					
			<hr>
			
			<div class = "row text-center ">
				
				<div class = "col ">
				
					<?php  love_post( $f['file_id'] ); ?>
				
				</div>
				
				<div class = "col">
				
					<small>
						<a href ="<?= $root ?>/library/download.php?file=<?= 'files/' . $f['book_id']  . '/' . $f['file_name']  ?>&section_name=<?=  $f['section_name'] ?>&file_custom_name=<?=  $f['custom_name'] ?>" >
							<span><i class = "fa fa-download"></i></span> 
						</a>
						
					</small>
				</div>
				
				<div class = "col ">
					<small class ="share" id = "<?= $domain .  $root . '/library/book.php?b=' . $f['book_id'] . '&f=' . $f['file_id']  ?>&s=PS">
						<span><i class = "fa fa-share"></i></span>  
						  Share
					</small>
				</div>
				
				<div class = "col-4">
					<small>
						<a href  = "<?= $domain .  $root . '/library/book.php?b=' . $f['book_id'] . '&f=' . $f['file_id']  ?>&s=goToBook">
							Go to Book   <span><i class = "fa fa-arrow-right"></i></span>   
						</a>
					</small>
				</div>
				
			</div>
			
			
		</div>
	</div><!--/ post -->

	<?php
	
	 endforeach;
	 
}

//old v_5  icons
/*



*/
    
    
    
