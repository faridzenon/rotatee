<link rel="stylesheet" href="html/style.css" type="text/css" media="screen" />
<?php

include 'logincheck.php';

// if the user has logged in
if($logincheck == 1)
{
	// get the Campaign ID
	$campid = $_GET['campid'];
	
	// display the Add Banner form
	echo'
	<form action="view.php?id='.$campid.'" method="post">
		<table border="0" cellpadding="5" cellspacing="0" style="font-size: 15px; margin: 10px;">
			<tr>
				<td align="right">Name</td>
				<td><input name="name" type="text" id="name" class="bigbox" /></td>
			</tr>
			<tr>
				<td align="right">Weight</td>
				<td><input name="weight" type="text" id="weight" class="bigbox" /></td>
			</tr>
			<tr>
				<td align="right" valign="top">Code</td>
				<td><textarea name="code" id="code" class="textbox" rows="7" cols="50"></textarea></td>
			</tr>
			<tr><td colspan="2" align="center"><input name="submit" type="submit" value="Submit" style="width: 100px;" /></td></tr>
		</table>
	</form>';
}
else
{
	// user not logged in
	header("Location: index.php");
}

?>