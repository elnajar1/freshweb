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


<div class="container-fluid">
	
	<div class="row">
			
		<div class="col-12 text-center">
	        <div class="py-5 my-5  m-auto">
		 	    <h1 class="font-weight-bold">Organize your <span id = "typed2" class=" text-primary font-weight-bold">Learning files</span><span class="cursor"> &nbsp;</span></h1>
		    	<small class="text-muted d-block"> freshweb make it easy to organize files and share them with your friends en'sha Allah </small>
        	</div>			
	    	<a href="#sign-in" class="btn btn-small  btn-outline-danger my-2  rounded  waves-effect waves-light">Sign in with email</a>
			
			<!-- Login with facebook -->
			<a href="<?php echo $loginURL ?>" style="background : #597CC5 ; max-width:300px" class="my-2 btn btn-block rounded  ">
				<span class="text-white"> 
			        <i class="fab fa-facebook-square "></i> 
	            	تسجيل الدخول عبر فيسبوك 
				</span>
			</a>		
        </div>
        
	</div>
	
    <div class="row text-center">
			
		<div class="col-12 col-md-5">
            <img src="layout/img/chat.jpg" alt="old method to share files" class="mx-auto d-block img-fluid">

<p class = "text-muted " >
استبدل الطريقة التقليدية في مشاركة الملفات
</p>
   
        </div>
        
        <div class="col m-auto">
            <div class="arrow-container">
                <div class="arrow">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 ">
             <img src="layout/img/book.jpg" alt="freshweb method to share files" class="mx-auto d-block img-fluid">

<p class = "text-muted " >

بطريقة  فريش ويب  المنظمة

</p>

        </div>
        
	</div>
    
	<div class="row p-5">
		<div class="col">
			<?php include 'search/searchBox.php'; ?>
		</div>	
	</div>

    <!--what fresh web is  -->
	<div class = "row m-auto text-center m-auto">
	    
	    <div class="col-12 col-sm-6">
		     <img src="layout/img/organize.jpg" alt="" class="m-auto w-75 d-block img-fluid">
		</div>	
		
		<div class="col-12 col-sm-6 m-auto">
		    <h1 class="text-primary py-4">
		         ما هو فريش ويب ؟
		     </h1>
            <h4 class ="text-muted">
                تتمثل فكره فريش ويب في استبدال الطريقة التقليدية من استخدام برامج المحادثات في مشاركه الريكوردات والتلخيصات المكتوبة والمصورة مع اصدقائك ودفعتك في صورة منظمة 
            </h4>
        </div>
        
	</div>
	
	<div class = "row text-center m-auto">
	    
		<div class="col-12 col-sm-6">
		     <img src="layout/img/book_small.jpg" alt="" class="mx-auto w-75 p-1 d-block img-fluid">

</div>	
		
		<div class="col-12 col-sm-6 m-auto">
		
	        <h1 class ="text-primary">
        الحياه احلي وهي منظمة
            </h1>
            <p class = "text-muted" >
        تستطيع تنظيم ملفات محاضرات كل ماده في مجلدات، كل مجلد باسم المحاضرة لتسهيل العثور اليها في اي وقت 
     
            </p>
        </div>
	    
	    
		<div class="col-12 col-sm-6">
		     <img src="layout/img/search.png" alt="" class="mx-auto w-25 py-3 d-block img-fluid">
		
	        <h4 class ="text-muted">
               اعثر علي ما تبحث عنة بسهولة
            </h4>
           
        </div>
	    

		<div class="col-12 col-sm-6">
		     <img src="layout/img/link.png" alt="" class="mx-auto w-25 py-4 d-block img-fluid">
	    
    <h4 class ="text-muted ">
               شارك تلخيصات والتسجيلات التعليميه مع زملائك  في الجامعة في  نظام تام
            </h4>
            
        </div>
	    
	</div>
	<!--/what fresh web is  -->
	
	
    <!--sing in and up  -->
	<div id="singIn" class="row text-center" >
		<div class="col">
		    
			<form method="post" action="register.php#singIn">
			    
				<div class="text-center ">
					<h2>Sign In</h2> 
					<?php include('includes/login_errors.php'); ?> 
				</div>
				
				<div class="form-group text-left ">
					<label for="a">Email</label>
					<input type="email" name="email" id="a" placeholder="email" class="form-control">
				</div>
				
				<div class="form-group text-left ">
					<label for="b">Password</label>
					<input type="password" id="b" name="password" placeholder="passward" class="form-control">
				</div>
				
				<a href="#sing-up">creat new acount?</a><br>
			    <button type="submit" name="login" class="btn btn-primary rounded ">Sign In</button>
			    
			</form>
			
	        <a href="<?php echo $loginURL ?>" style="background : #597CC5 " class="w-100 btn d-block btn-block rounded  ">
			    <span class="text-white"> 
			     <i class="fab fa-facebook-square "></i> 
	             تسجيل الدخول عبر فيسبوك 
			    </span>
		    </a>

		</div>
		
		<div id="singUp" class="col my-2 bg-primary text-white rounded">
		    
			<form method="post" action="register.php#singUp" enctype="multipart/form-data">
				
				<div class=" text-center">
					<h2 class=" text-white"> Sign Up Now </h2> 
					<?php include('includes/errors.php'); ?>
				</div>
				
				<div class="form-group">
					<input type="text" name="yourname" placeholder="Your Name" class="form-control">
				</div>
				
				<div class="form-group">
					<input type="email" name="email" placeholder="E-mail" class="form-control">
				</div>
				
				<div class="form-group">
				    <input hidden type="text" name="username" placeholder="User Name" class="form-control">
				</div>
				
				<div class="form-group">
					<input type="password" name="password_1" placeholder="Password" class="form-control">
				</div>
				
				<div class="form-group">
					<input type="password" name="password_2" placeholder="Confirm Password" class="form-control">
				</div>
					
				<div class="form-group"> 
				    <span>choose a profile photo </span>
					 <input type="file" class="text-muted" name="avatar" value="choose a profile photo" accept="image/*">
				</div>
					 
			    <button type="submit" name="signup" class="btn btn-white rounded">Sign Up</button>
		    
			</form>
			
		</div>
    </div><!-- /sing in and up  -->


	
	<div class=" row  bg-dark ">
		<div class="col-12 col-md-7 m-auto  "> 
		    <?php  
		        // get_posts( $random_files );  
		    ?> 
		</div>
	</div>
	
	<div class="row font-small text-muted bg-muted   ">
		<div class="col text-muted  text-center  ">
		    <p>
		        Icons made by <a href="https://www.flaticon.com/authors/smalllikeart" title="smalllikeart">smalllikeart</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>
		    </p>
			<a href="privacy.php">Privacy</a> - <a href="about.php">About</a>
		</div>
	</div>
	
</div><!-- container  -->

<?php
include 'includes/footer.php';
?>
    
    
    
