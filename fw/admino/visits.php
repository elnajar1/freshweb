<?php
	
	include "../includes/header.php";
	include "adminServer.php";
	
	//stages
	$sql ="SELECT u.id AS  'user_id', u.name , u.fb_name, fw_visits.* FROM 
	fw_visits
LEFT JOIN  fw_users u
	ON
	u.id  = fw_visits.user_id
WHERE fw_visits.page != 'register.php' 
	ORDER BY fw_visits.id DESC
	LIMIT 700";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([]);
	$visits = $stmt->fetchall();
	//var_dump( $visits )
?>

<div class="container">

    <div class=" row ">
        <div class=" col-12">
            <table class="table table-striped">
  		<thead>
  		<tr>
  			<th scope="col">id</th>
   			 <th scope="col">name</th>
   			 <th scope="col" >ip</th> 
    			<th scope="col" >page</th>
    			<th scope="col" >time</th>
    			<th scope="col" >url</th>
		  </tr>
		  </thead>
  		<tbody>
		  <?php
		  	 foreach($visits as $v){
  			echo '<tr>' ;
  				echo '<th scope="row">' .  $v['id']  . '</th>' ;
   				echo ' <td><a href = "' .  $root . '/user/profile.php?u=' . $v['user_id'] . '">' .  $v['name'] . ' - ' . $v['fb_name'] . '</a></td>';
   				echo  '<td><p>' .  $v['ip']  . '</p></td>' ;
    				echo  '<td>' .  $v['page']  . '</td>' ;
    				echo  '<td>' .  $v['time']  . '</td>' ;
    				echo  '<td>' .  $v['url']  . '</td>' ;
  			echo '</tr>' ;
  
  			}
 		?>
 	       </tbody>
		</table>
        </div>
    </div>
    
</div>

<?php

include "../includes/footer.php";
//nclude "../../fresh_code/index.php";
    
    
    
