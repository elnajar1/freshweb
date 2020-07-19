<?php

	$sql = "SELECT fw_groups.name , fw_groups.id , fw_university.name , fw_science_field.name 
		FROM fw_groups   
		LEFT JOIN fw_university  ON fw_groups.university = fw_university.id  
		LEFT JOIN fw_science_field  ON fw_groups.science_field  = fw_science_field.id 
		LEFT JOIN fw_group_members  ON fw_groups.id  = fw_group_members.group_id
		WHERE  fw_group_members.user_id = ? AND fw_group_members.status = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([ $user_id, 1]);
	$mygroups = $stmt->fetchall();

	//var_dump($mygroups);
	//include "includes/header.php";

?>

<div class=" container-fluid  bg-muted">
	<!--profile-->
	<a href = "<?= $root ?>/user/profile.php">
		<div class=" row ">
			<div class=" col-3">
				<div class ="bg-muted    rounded m-1">
					<img src="<?= $user_avatar ?>" class="img-fluid rounded " onerror="this.src='/fw/uploads/avatars/user.jpeg';" />
				</div>
			</div>

			<div class=" col">
				<h4 class="font-weight-bold text-white my-3 m-auto"><?= $user_name ?></h4>
			</div>
		</div>
	</a>
	<!--/profile-->
	<div class=" row ">
		<div class=" col-12">
			<p class="text-muted border-bottom">My groups </p>
		</div>
	</div>
	
	<?php foreach ($mygroups as $mygroup): ?>

	<a href="<?= $root ?>/group/groupProfile.php?g=<?= $mygroup[1] ?>" class = "w-100">
		<div class=" row m-1 p-1 border rounded bg-white text-dark z-depth-1 w-100">
			<div class=" col">
				<div class=" row ">
					<div class="col-12">
						<p class="m-1"><?= $mygroup[0] ?></p>
					</div>
					<div class="col-12 ">
						<small class="text-info text-cente m-1 "><?= $mygroup[2] ?></small>
					</div>
				</div>
			</div>
			<div class=" row">
				<div class="col-12	">
					<small class="text-muted text-center ml-3 w-100"><?= $mygroup[3] ?></small>
				</div>
			</div>
		</div>
	</a>
	
	<?php endforeach; ?>

	<div class=" row ">
		<div class=" col ">
			<a href="<?= $root ?>/group/addGroup.php" class="border rounded w-100 bg-dark z-depth-1 text-light " >
				<div class=" row">
					<div class=" col-3 m-1  ">
						<span style="font-size : 2em;"> <i class="far  fa-plus-square"></i> </span>
					</div>
					<div class=" col m-2">
						<p class="font-weight-bold text-white">Create new group</p>
					</div>
				</div>
			</a>
		</div>
	</div>
	
	<a href = "<?= $root ?>/admin/" class = " d-none w-100 border-top">
		<div class = "row ">
	
			<div class = "col-4">
				<span style="font-size : 2em;"> <i class="fab fa-accusoft"></i> </span>
			</div>
			<div class = "col-6 ">
				<p>Admin Page  </p>
			</div>
			
		</div>
	</a>
	
	
	<a href = "<?= $root ?>/logout.php" class = "w-100 border-top">
		<div class = "row ">
	
			<div class = "col-2 p-2 ">
				<span style="font-size : 2em;"> <i class="fas fa-sign-out-alt"></i> </span>
			</div>
			<div class = "col p-2 text-left">
				<p class = " font-weight-bold text-white " >Logout </p>
			</div>
			
		</div>
	</a>
	
</div>
    
<?php
//include "includes/footer.php";
//include "../fresh_code/index.php";
    
    
  
    
    
    
