<?php
	
	
	include "config.php";
//	include "facebook_login/config.php";

	//visits analysis 
	$page = basename($_SERVER['PHP_SELF']);

$url =$_SERVER['REQUEST_URI'];  

if (  substr( $url, -15) !== "getMessages.php"):
		
	$sql = "INSERT INTO fw_visits ( user_id, ip, page, url, host ) VALUES (?,?,?,?,? )";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id , $ip , $page, $url, $domain]);

endif;
	
	//echo ini_get('session.gc_maxlifetime');
	
	//Redirect url for after login
//	$redirectURL = $redirectURL =  $domain . "/fw/facebook_login/fb-callback.php?redirect=" . $domain  . $_SERVER['REQUEST_URI'] ;
	$permissions = ['email'];
	//facebook login url for  login a href 
	//$loginURL = $helper->getLoginUrl($redirectURL, $permissions);

?>
			</div>
		</div>
	</div>
		
	
	<!-- Footer -->
	<div class="footer  font-small text-light  bg-dark ">

 		 <div class="text-muted  text-center py-3 ">   - - -  وَعِلْمٍ يُنْتَفَعُ بِهِ  - - -   
  		</div>

	</div>
	<!-- Footer -->

	<!-- sing in small form -->
	<div style = "display:none;position:fixed;bottom:0px;max-width:500px" class = "sign-in-advise  container ">
		<div class = "row bg-white border-top">
		
			<div class = "col-12 w-100 ">
				<h3 class = "text-muted text-center ">Please sing in frist  </h3>
				
				<!-- Login with facebook 
      			 <a  href="<?php echo $loginURL ?>" class=" d-block w-100 loginBtn loginBtn--facebook"> تسجيل الدخول عبر فيسبوك </a>
 -->    
				<div class = "row">
					<div class = "col-7">
						<a class = " m-1 btn btn btn-primary btn-small " href = "<?= $root ?>/register.php"> Create Acount </a>
					</div>
					<div class = "col">
						<button class = "close-sign-in-advise m-1 btn btn-default z-depth-0 btn-small ">No </button>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
	
	<!-- The Modal -->
	<script src="/fw/layout/js/main.js"></script>
	<div id="myModal"class="img-modal mt-5">

	  	<!-- The Close Button -->
  		<span class="close" >close &times; </span>
	 
		 <!-- Modal Content (The Image) -->
 		<img style = "max-width:80%" class="img-modal-content " id="img01">

  		<!-- Modal Caption (Image Text) -->
  		<div id="caption"></div>
	  </div>
	  
    <!-- jquery -->
   <script src="/fw/layout/js/jquery.js" ></script>
   
   <!-- library -->
    <script src="/fw/layout/library/js/main.js"></script>
    
   <!--Bootstrap -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <!-- MDB core JavaScript -->
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.1/js/mdb.min.js"></script>
   
    <!-- typed -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    
   <!-- main -->
   <script src="/fw/layout/js/main.js?1"></script>
   
   <!-- Alaa css -->
   <script src="/fw/layout/js/reg.js"></script>

    <!-- messages -->
    <script src="/fw/layout/messages/js/main.js?1"></script>
    
   <!-- library -->
    <script src="/fw/layout/library/js/main.js?1"></script>
    
    <!-- group -->
    <script src="/fw/layout/group/js/main.js"></script>
    
    <!-- search -->
    <script src="/fw/layout/search/js/main.js"></script>
    
    <!-- videojs  -->  
    <script src='https://vjs.zencdn.net/7.4.1/video.js'></script> 
    
   
    <!-- add to home screen chrome -->
    
    <script type="text/javascript">

 	if( 'serviceWorker' in navigator) {
 	   console.log("Will the service worker register?");

navigator.serviceWorker.register('/fw/includes/addToHomeScreen/service-worker.js').then(function(reg){

   	   console.log("Yes, it did.");
  	   }).catch(function(err) {
   	     console.log("No it didn't. This happened:"  + err);
 	   });
 	}

  </script>
<?php

/*
   
   <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

  <!-- fresh code --> 
    <script src="../../fresh_code/codemirror/lib/codemirror.js"></script>
    <script src="../../fresh_code/codemirror/lib/javascript.js"></script>
    <script src="../../fresh_code/codemirror/addon/selection/active-line.js"></script>
    <script src="../../fresh_code/codemirror/mode/xml/xml.js"></script>
   <script src="../../fresh_code/codemirror/mode/clike/clike.js"></script>
    <script src="../../fresh_code/js/fresh_code.js"></script>
    <link rel=stylesheet href="../doc/docs.css">
<?php
	$fc_path = "../../fresh_code/codemirror/";
?> 
  <link rel="stylesheet" href="<?= $fc_path ?>lib/codemirror.css">
  <link rel="stylesheet" href="<?= $fc_path ?>addon/fold/foldgutter.css" />
  <script src="<?= $fc_path ?>lib/codemirror.js"></script>
  <script src="<?= $fc_path ?>addon/fold/foldcode.js"></script>
  <script src="<?= $fc_path ?>addon/fold/foldgutter.js"></script>
  <script src="<?= $fc_path ?>addon/fold/brace-fold.js"></script>
  <script src="<?= $fc_path ?>addon/fold/xml-fold.js"></script>
  <script src="<?= $fc_path ?>addon/fold/markdown-fold.js"></script>
  <script src="<?= $fc_path ?>addon/fold/comment-fold.js"></script>
  <script src="<?= $fc_path ?>mode/javascript/javascript.js"></script>
  <script src="<?= $fc_path ?>mode/xml/xml.js"></script>
  <script src="<?= $fc_path ?>mode/markdown/markdown.js"></script>
    <?php
    	@include "../fresh_code/index.php";
    	
*/
?>

  </body>
</html>
    
    
    
