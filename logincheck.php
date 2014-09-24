<?php

include 'config.php';

if (isset($_COOKIE['Rotatee']))  
{ 
	$cookie_info = explode("-", $_COOKIE['Rotatee']);  //Extract the Data 
	$username = $cookie_info[0]; 
	$password = $cookie_info[1];
   	
	$query = mysql_query("SELECT * FROM users WHERE Username = '$username' AND Password = '$password' LIMIT 1") or die(mysql_error());
	
	$row = mysql_fetch_array($query);

	// now we check if they are activated
	if(mysql_num_rows($query) > 0)
	{
		$logincheck = 1;
		$userid = $row['id'];
	}
	else
	{
		$logincheck = 0;
	}
}
else
{
	$logincheck = 0;
}

?>
