<?php

include('logincheck.php');

if($logincheck == 1)
{

	$campid = $_POST['id'];	

	if(isset($_POST['name']))
	{
		$name = addslashes(urldecode($_POST['name']));
		
		$query = mysql_query("UPDATE campaigns SET name = '$name' WHERE id = '$campid'") or die(mysql_error());
		
		echo'name'.$campid.'|<a href="view.php?id='.$campid.'">'.stripslashes($name).'</a>';
		
		exit;
	}
		
	$query = mysql_query("SELECT * FROM campaigns WHERE id = '$campid' ORDER BY id ASC") or die(mysql_error());
	
	if($query)
	{
		$row = mysql_fetch_array($query);
		
		echo'name'.$campid.'|
		<div style="padding: 0; margin: 0;">
		<form name="renameform" id="renameform" onsubmit="rename_process(); return false;">
		<input name="name" type="text" id="name" value="'.$row['name'].'" />
		<input name="id" type="hidden" id="id" value="'.$campid.'" />
		<input name="rename" type="submit" id="rename" value="Rename" />
		</form>
		</div>
		';
	} 
	else 
	{
		echo '<b>Error</b>';
	}	
}
else
{
	header("Location: index.php");
}

?>
