<?php

include('logincheck.php');

// if the user is logged in
if($logincheck == 1)

{
	$id = $_POST['id'];
	$count = $_POST['count'];
	
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
	
	// select the details of the banner to be editted
	$query = mysql_query("SELECT * FROM banners WHERE id = '$id' ORDER BY id ASC") or die(mysql_error());
	
	if($query)
	{
		$row = mysql_fetch_array($query);
		
		$name = stripslashes($row['name']);
		$weight = stripslashes($row['weight']);
		$code = htmlentities(stripslashes($row['code']));
		
		// display it in an EDIT form
		echo'banner_name'.$id.'|<div class="celldiv" style="width: 529px;">
		<form name="editform" id="editform" onsubmit="edit_process(); return false;">
		<table border="0" cellpadding="0" cellspacing="5">
		<tr>
			<td align="right">Name</td>
			<td>
				<input name="name" type="text" id="name" class="bigbox" value="'.$name.'" />
				<input name="id" type="hidden" id="id" value="'.$id.'" />
				<input name="count" type="hidden" id="count" value="'.$count.'" />
			</td>
		</tr>
		<tr>
			<td align="right">Weight</td>
			<td><input name="weight" type="text" id="weight" class="bigbox" value="'.$weight.'" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Code</td>
			<td><textarea name="code" id="code" class="textbox" rows="7" cols="50">'.$code.'</textarea></td>
		</tr>
		<tr><td colspan="2" align="center"><input name="edit" type="submit" value="Save" style="width: 100px;" /></td></tr>
		</table>
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
	// user not logged in
	header("Location: index.php");
}

?>
