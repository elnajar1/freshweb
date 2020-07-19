<?php
	include "includes/config.php";

	if ( isset($user_id) ){
		header("location: home.php");
		exit;
	}

	include 'includes/header.php';
	include "facebook_login/config.php";
	
	//Redirect url for after login 
	$redirectURL = $domain . "/fw/facebook_login/fb-callback.php";
	$permissions = ['email'];
	//facebook login url for  login a href 
	$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
	
	//random files
	$sql ="SELECT f.id AS 'file_id',   f.author, f.book_id, f.name AS 'file_name', f.custom_name, f.type, f.time, 
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
		 u.id = f.uploader_id
		ORDER BY RAND() LIMIT 25";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$random_files = $stmt->fetchall();
	
?>

<div class="container-fluid MainContainer ">
	
	
	
	<div class="row ParallaxContainer  ">
		
		
		
		<div class="col-12 text-center">
			<h1 class="text-primary " style="margin:0px;margin-left:8%">FreshWeb </h1>
			<p class="text-muted" style="margin:0px;margin-left:8%"> Organize your lectures and files & share them with your friends </p>
			<a href = "#sign-in" class="btn btn-small  btn-outline-danger m-2  rounded " >Sign in with email</a>
			
			<!-- Login with facebook -->
			<a href="<?php echo $loginURL ?>" style="background : #597CC5 " class="w-100 btn   btn-block rounded  ">
				<span class="text-white"> 
			        <i class="fab fa-facebook-square "></i> 
	            	تسجيل الدخول عبر فيسبوك 
				</span>
			</a>		

</div>


	</div>
	
	<div class="row" style ="background:linear-gradient(to bottom, rgba(0,0,0,0.4) 30%, #2b3237) ;" >
		<div class="col">
			<?php include 'search/searchBox.php'; ?>
		</div>	
	</div>

	<div class="row  bg-white py-2" id = "sign-in">
		<div class="col col-md-7 text-center m-auto d-none d-md-block  ">
			<h1 class="text-dark ">sing in</h1>
		</div>
		<div class="col col-md-5">
			<form method="post" action="register.php">
				<div class="text-center ">
					<h2>Sign In</h2> <?php include('includes/login_errors.php'); ?> <div class="form-group text-left ">
						<label for="a">Email</label>
						<input type="email" name="email" id="a" placeholder="email" class="form-control">
					</div>
					<div class="form-group text-left ">
						<label for="b">Password</label>
						<input type="password" id="b" name="password" placeholder="passward" class="form-control">
					</div>
					<a href="#sing-up">creat new acount?</a><br>
					<button type="submit" name="login" class="btn btn-primary rounded ">Sign In</button>

	</div>


			</form>
			<br>
			<a href="<?php echo $loginURL ?>" style="background : #597CC5 " class="w-100 btn   btn-block rounded  ">
				<span class="text-white"> 
			        <i class="fab fa-facebook-square "></i> 
	            	تسجيل الدخول عبر فيسبوك 
				</span>
			</a>

		</div>
	</div>
	<div class="row  text-white py-2" id="sing-up">
		<div class="col-12 col-md-5 my-3">
			<form method="post" action="register.php" enctype="multipart/form-data">
				<div class=" text-center signup p-3">
					<h2 class="text-dark ">Sign Up Now</h2> <?php include('includes/errors.php'); ?> <div class="form-group">
						<input type="text" name="yourname" placeholder="Your Name" class="form-control">
					</div>
					<div class="form-group">
						<input type="email" name="email" placeholder="E-mail" class="form-control">
					</div>
					<input hidden type="text" name="username" placeholder="User Name" class="form-control">
					<div class="form-group">
						<input type="password" name="password_1" placeholder="Password" class="form-control">
					</div>
					<div class="form-group">
						<input type="password" name="password_2" placeholder="Confirm Password" class="form-control">
					</div>
					
					<span class = "text-dark">choose a profile photo </span>
					
					<div class="form-group"> 
						 <input type="file" class="text-muted" name="avatar" value="choose a profile photo" accept="image/*">
					</div>
					 
				    <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
				</div>
			</form>
		</div>
		<div class="col text-center m-auto d-none d-md-block  col-md-7">
			<h1 class = "text-white">Or make a new acount</h1>
		</div>
	</div>
	<div class=" row  py-2 w-100 text-center m-auto bg-white ">
        	    <h1  class=" w-100 text-cente" > Ready? </h1>
		<div class="col-12  "> <?php include "libraryTimeLine.php" ?> </div>
	</div>
	
	<div class=" row   text-muted  my-3 text-center border-top">
		<div class="col-12 col-md-7 m-auto   ">
			<h4 class=" text-white p-2" > What people shared on FreshWeb </h4>
		</div>
	</div>
	
	<div class=" row  bg-dark ">
		<div class="col-12 col-md-7 m-auto   "> <?php   get_posts( $random_files );  ?> </div>
	</div>
	<div class="row font-small text-light  bg-dark ">
		<div class="col text-muted  text-center  ">
			<a href="privacy.php">Privacy</a> - <a href="about.php">About</a>
		</div>
	</div>
</div><!-- container  -->

<?php
include 'includes/footer.php';
?>
    
    
    
