<?php

include('logincheck.php');

	// if EDITED DATA has been submitted
	if(isset($_POST['edit']))
	{
		$id = rawurldecode($_POST['id']);
		$name = addslashes(rawurldecode($_POST['name']));
		$weight = addslashes(rawurldecode($_POST['weight']));
		$code = addslashes(rawurldecode($_POST['code']));
		
		// update the database
		$query = mysql_query("UPDATE banners SET name = '$name', code = '$code', weight = '$weight' WHERE id = '$id'") or die(mysql_error());
		
		// display the updated data
		echo 'banner_name'.$id.'|<div class="celldiv" style="width: 450px;">'.$name.'</div>
								<div class="celldiv tcenter" style="width: 59px;">'.$weight.'</div>';
		exit;
	}
  
?>
