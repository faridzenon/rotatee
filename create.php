<link rel="stylesheet" href="html/style.css" type="text/css" media="screen" />
<?php

include 'logincheck.php';

// if the user is logged in
if($logincheck == 1)
{
	// display the Add Campaign form
	echo'
	<form style="margin: 0px;" action="index.php" method="post">
	<table border="0" cellpadding="5" cellspacing="0" style="font-size: 16px;" align="center">
	<tr>
		<td align="right">Name</td>
		<td><input name="name" type="text" id="name" class="bigbox" /></td>
	</tr>
	</table>
	</form>
	';
}
else
{
	// user not logged in
	header("Location: index.php");
}

?>
