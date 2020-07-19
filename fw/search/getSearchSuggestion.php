 <!-- Font Awesome -->
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
 
<?php
	include "../includes/connection.php";
	$search = filter_var (  $_POST['search']  , FILTER_SANITIZE_STRING  ) ; 
	
	//books 
	$sql ="SELECT fw_books.id AS 'book_id', fw_science.name AS 'name'
		FROM fw_books 
		JOIN fw_science ON fw_books.science_id = fw_science.id 
		WHERE fw_science.name LIKE ? LIMIT 2";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%"  ]);
	$books = $stmt->fetchall();

	//sections 
	$sql ="SELECT * FROM fw_sections WHERE name LIKE ? LIMIT 3";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%"  ]);
	$sections = $stmt->fetchall();

	//files 
	$sql ="SELECT * FROM fw_files WHERE  custom_name LIKE ? LIMIT 5";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%"  ]);
	$files = $stmt->fetchall();
	
	//sections 
	$sql ="SELECT * FROM fw_users WHERE name LIKE ? LIMIT 2";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ "%" .  $search .  "%"  ]);
	$users = $stmt->fetchall();

	echo '<a href = "#" class ="d-none text-dark font-weight-bold">Show all results</a><hr class = "m-0">' ;

	if(  count($books) > 0  ){
		
		foreach( $books as $book ){
			
			echo ' <i class="fas fa-book text-muted "></i> <a href = "/fw/library/book.php?b=' . $book['book_id']  . '" class = "text-dark ">' .  $book['name'] .  '</a><hr class = "m-0">';
		}
		
	}

	if(  count($sections) > 0  ){
		
		foreach( $sections as $section ){
			
			echo ' <i class="far fa-folder text-primary"></i> <a href = "/fw/library/book.php?b=' . $section['book_id']  . '&section=' . $section['id'] . '#' . $section['id'] . '" class = "text-dark ">' .  $section['name'] .  '</a><hr class = "m-0">';
		}
		
	}


	if(  count($files) > 0  ){
		
		foreach( $files as $file ){
			
			if($file['type']  == "img"):
			
				echo ' <i class = " text-info fa fa-image"></i>' ;
			
			elseif($file['type']  == "doc"):
				
				echo ' <i class = " text-danger fa fa-file-alt"></i>' ;
				
			elseif($file['type']  == "audio"):

				echo  ' <i class = " text-primary fa fa-music">' ;
				
			elseif($file['type']  == "video"):
				
				echo ' <i class = " text-info fa fa-video"></i>' ;
			
			endif;

			echo ' <a href = "/fw/library/book.php?b=' . $file['book_id'] . '&f=' .$file['id'] . '" class = "text-dark ">' .  substr($file['custom_name'],0,30) .  '</a><hr class = "m-0">';
		}
		
	}

	if(  count($users) > 0  ){
		
		foreach( $users as $user ){
			
			echo ' <i class="far fa-user text-success"></i> <a href = "/fw/user/profile.php?u=' . $user['id']   . '" class = "text-dark ">' .  $user['name'] .  '</a><hr class = "m-0">';
		}
		
	}

	/*
	elseif( count($files) == 0  ){
		echo '<a href = "#" class ="text-dark font-weight-bold">Show all results</a>' ;
	}
	*/
?>

<!-- search  js -->
<script src="/fw/layout/search/js/main.js"></script>


  
