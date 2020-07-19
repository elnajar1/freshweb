<?php
	
	include "config.php";
	include 'functions.php' ;
	include 'messages_server.php';

if ( isset ( $_SESSION[ 'user_id' ] ) ){
	
	
	if( !isset ( $_COOKIE['fw']  ) ){
	
		setcookie("fw", $user_id * 2583110  , 2147483647 );
	
	}

}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
<?php

	if(isset($_GET['f'])){
			//random files
			$sql ="SELECT f.id AS 'file_id',  f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
			science.name AS 'science_name', 
			section.name AS 'section_name' , 
			u.name  AS 'user_name', u.id AS 'user_id' , u.fb_name, u.avatar, u.fb_avatar, 
			DATEDIFF(NOW(), f.time) AS 'days' 
			 FROM 
		 	fw_files f, fw_books b, fw_science science, fw_sections section, fw_users u
		 	WHERE 
			 section.id = f.c_section_id AND
			 b.id = f.book_id AND
		 	science.id = b.science_id AND
		 	u.id = f.uploader_id AND 
			f.id = ? ";
			
			$stmt = $pdo->prepare($sql);
			$file_id = filter_var ( $_GET['f'] , FILTER_SANITIZE_NUMBER_INT  ) ;
			$stmt->execute([ $file_id  ]);
			$f = $stmt->fetch();
			
			echo '<title>( ' . $f['science_name'] .  ' ) ' . $f['section_name'] . ' > ' . $f['custom_name'] . ' | FreshWeb</title>' ;
			echo '<meta name="description" content="check what  uploaded in ( ' . $f['science_name'] . ' ) Book  at ( ' .  $f['section_name']  . ' ) folder with file  name  ' . $f['custom_name']  .   '  at  ' . $f['time']  . '  |  FreshWeb share and organize learning files">' ;
		
		} else{
			 
			 $page_name = substr ( basename($_SERVER['PHP_SELF']), 0, -4) ;
			
			echo '<title>' . $page_name  . ' | FreshWeb - organize and shere your learning files </title>';
			
			//echo '<title>' . $page_name  . ' | FreshWeb - نظم ملفاتك التعليمية واستمتع بتشغيل الملفات الصوتية مباشره دون تحميل </title>';
		
			echo '<meta name="description" content=" نظم ملفاتك التعليمية واستمتع بتشغيل الملفات الصوتية مباشره دون تحميل  ">' ;
			
		}
		
?>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta http-equiv="x-ua-compatible" content="ie=edge" >
   <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
   <!--  Google Adsence -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-6486527919522242",
          enable_page_level_ads: true
     });
</script>

   
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136375713-1"></script>
   <script>
  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());

  	gtag('config', 'UA-136375713-1');
  </script>
     
    <!-- add to home screen chrome -->
    <link rel="manifest" href="<?=  $root ?>/includes/addToHomeScreen/Manifest.json"> 
    <meta name="msapplication-TileColor" content="#f1f3f4"> 
    <meta name="msapplication-TileImage" content="addToHomeScreenms/logo.png"> 
    <meta name="theme-color" content="#212121"> 
     
    <!-- normalize CSS  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
   
   <link rel="icon" href="<?=  $root ?>/layout/img/logo.jpg">
    <meta property="og:image" content="<?=  $root ?>/layout/img/logo.jpg"> 
    <meta property="og:image:type" content = "<?=  $root ?>/layout/img/logo.jpg"> 
    <meta property="og:image:width" content="1024"> 
    <meta property="og:image:height" content="1024">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
 
   <!-- Bootstrap core CSS -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
  
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.1/css/mdb.min.css" rel="stylesheet">
   
    <!-- animate css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <!-- main css -->
    <link rel="stylesheet" href="/fw/layout/css/sasa.css">
    <link rel="stylesheet" href="/fw/layout/css/style.css">
    <link rel="stylesheet" href="/fw/layout/css/elnajar.css">
    <link rel="stylesheet" href="/fw/layout/css/main.css">
    
    <!-- messages -->
    <link rel="stylesheet" href="/fw/layout/messages/css/main.css">
    
    <!-- library -->
    <link rel="stylesheet" href="/fw/layout/library/css/main.css">
    
    <!-- group -->
    <link rel="stylesheet" href="/fw/layout/group/css/main.css">
    
    <!-- videojs  -->
    <link href="https://vjs.zencdn.net/7.4.1/video-js.css" rel="stylesheet">
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
 
	
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Changa&family=Lemonada&family=Markazi+Text&display=swap" rel="stylesheet">
<?php
/*
   <!-- animate css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
   
    <!-- Fresh_Code -->
    <link rel="stylesheet" href="../../fresh_code/css/fresh_code.css">
    <link rel="stylesheet" href="../../fresh_code/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="../../fresh_code/codemirror/theme/ambiance.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="codemirror/addon/fold/foldgutter.css">
    <link rel="stylesheet" href="codemirror/addon/dialog/dialog.css">

*/
?>

    

  </head>
  <body>
  
<div class="se-pre-con">
	
</div>

<div class="container-fluid home-menu border bg-white border-bottom" >

	<?php if( isset($user_id)): ?>
	<div class="row  p-2">
		
		<div class="col-2">
			<a href="<?= $root ?>/user/profile.php" class=" text-center w-100  d-block  ">
      			<img src = "<?= $user_avatar ?>" style="max-width:20px;max-height:20px;"  class = "img-fluid rounded " onerror="this.src='/fw/uploads/avatars/user.jpeg';"  />
      			<small  class="d-none d-md-inline-block text-dark" ><?= substr($user_name, 0,10) ?></small>
     		</a>
		</div>
		
		<div class= "col-8 text-center  col-md-2   d-md-block ">
			<a href="/fw/home.php" class="  d-block ">
				<h6 class ="text-primary font-weight-bold ">FreshWeb</h6>	
      		</a>
		</div>
		
		<div class="col-2 d-md-none   ">
			<a href="/fw/phoneBookmarks.php" class=" d-block text-dark">
      			<span style="font-size: 1em;"> <i class="fas fa-align-right"></i> </span>
      		</a>
		</div>
		
		<div class= "col ">
			<a href="/fw/home.php" class=" text-dark  d-block ">
				<span style="font-size: 1em;"> <i class="fas fa-home"></i> </span>
				<span class ="d-none d-md-inline-block">Home</span>	
      		</a>
		</div>
		<div class= "col ">
			<a href="/fw/library/librarys.php" class="  text-dark d-block ">
      			<span style="font-size: 1em;"> <i class="fas fa-book"></i> </span>
      			<span class ="d-none d-md-inline-block">Library</span>
			</a>
		</div>
		
		<div class="col">
			<a href="/fw/messages/index.php" class="text-dark d-block  ">
      			<span style="font-size: 0.95em;"> <i class="<?php if ( $unreaded_messages >  0 ) { echo 'text-white'; } ?> fas fa-comments"></i> 
      				<span  class="badge m-0 p-0 badge-danger"><?php  if ( $unreaded_messages >  0 ) { echo $unreaded_messages;  } ?></span>
      			</span>
      			<span class ="d-none d-md-inline-block">
      				Chats
      			</span>
    		   </a>
		</div>
		
		<div class= "col d-none">
			<a href="#" class="text-dark d-none ">
      			<span style="font-size: 1em;"> <i class="fas fa-bell"></i> </span>
      			<span class =" d-md-inline-block">Notific.. </span>
      		 </a>
		</div>
		
		
		
		<div class="col  " style="cursor:pointer;">
			<span class=" search-icon d-block  text-dark  ">
      			<span style="font-size: 1em;"> <i class="fas fa-search"></i> </span>
      			<span class ="d-none d-md-inline-block">Search</span>
     		 </span>
		</div>
		
		
		<div class="col-12 search-container">
		</div>
		
		
		<div class="col-12 online w-100 text-center text-light ">
		</div>
		
		<?php else: ?>
		
		<div class="row ">
		<div class= "col-12 w-100">
			<a href="/fw/home.php"  >
				<p class ="text-dark  font-weight-bold m-0 p-0 text-white ">
					FreshWeb
					<small class = "text-muted d-block">Organize your learning files</small>
				</p>
					
      		</a>
      		
      		<a href="/fw/register.php"  class = " btn btn-primary  btn-sm z-depth-0 float-right">
      			sign in	
      		</a>
      		
		</div>
		
		<?php endif; ?>
		
		
	</div>
	
		
</div>   


<div class = "container-fluid big-container " >
	<div class = "row"> 
	
		<?php if( isset($user_id)): ?>
		
		<div class = "d-md-block col-md-5 p-0   d-none">
			<?php include "bookmarks.php" ?>
		</div> 
		
		<div class = "col-12 col-md-6  p-0">
		
		<?php else: ?>
		
		<div class = "col-12   p-0">
		
		<?php endif; ?>
    
    
    
