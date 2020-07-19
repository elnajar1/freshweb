<?php	
	$admins_id = [ 1, 33,19, 54];
	
	if (  !in_array ($user_id, $admins_id )){
		
		header( "location: ../home.php");
		echo "You can not access this page";
		exit;
		
	}
	
	include "../includes/connection.php";
	
	echo "<pre>";
	//var_dump($_POST);
	echo "</pre>";
	
	$status = "welcom";

	if($_POST[ 'university_name' ] && $_POST[ 'university_arabic_name' ]   ){
		
		$name = $_POST[ 'university_name' ];
		$arabic_name = $_POST[ 'university_arabic_name' ];
		$short_name = $_POST[ 'university_short_name' ];
		$url = $_POST[ 'university_url' ];
	
		//insert into DB 
		$sql = "INSERT INTO fw_university(name , arabic_name  , short_name , url) VALUES (? , ? ,? ,? ) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name , $arabic_name  , $short_name, $url ]);
		
		$status = $name .  " Added successfuly #! ";
		
	}

	if($_POST[ 'science_field_name' ]    ){
		
		$name = $_POST[ 'science_field_name' ];

		//insert into DB 
		$sql = "INSERT INTO fw_science_field (name ) VALUES (? ) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name  ]);
		
		$status = $name .  " Added successfuly #! ";
		
	}

	if($_POST[ 'stage_name' ] && $_POST[ 'stage_arabic_name' ]   ){
		
		$name = $_POST[ 'stage_name' ];
		$arabic_name = $_POST[ 'stage_arabic_name' ];

		//insert into DB 
		$sql = "INSERT INTO fw_edu_stage(name , arabic_name  ) VALUES (? , ? ) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name , $arabic_name  ]);
		
		$status = $name .  " Added successfuly #! ";
		
	}

	//level
	if($_POST[ 'level_name' ] && $_POST[ 'level_arabic_name' ]   ){
		
		$name = $_POST[ 'level_name' ];
		$arabic_name = $_POST[ 'level_arabic_name' ];

		//insert into DB 
		$sql = "INSERT INTO fw_edu_level(name , arabic_name  ) VALUES (? , ? ) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name , $arabic_name  ]);
		
		$status = $name .  " Added successfuly #! ";
		
	}

	//semester
	if($_POST[ 'semester_name' ] && $_POST[ 'semester_arabic_name' ]   ){
		
		$name = $_POST[ 'semester_name' ];
		$arabic_name = $_POST[ 'semester_arabic_name' ];

		//insert into DB 
		$sql = "INSERT INTO fw_edu_semester(name , arabic_name  ) VALUES (? , ? ) ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name , $arabic_name  ]);
		
		$status = $name .  " Added successfuly #! ";
		
	}
