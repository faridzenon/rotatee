<?php

include('logincheck.php');

// delete what ? Campaign or Banner ?
$type = $_POST['type'];

if($logincheck == 1)
{
	switch($type)
	{
		// if Campaign
		case "camp":	
				$campid = $_POST['id'];
				// delete it
				mysql_query("DELETE FROM campaigns WHERE id = '$campid'") or die(mysql_error());
				/*
				$query = mysql_query("SELECT * FROM banners WHERE campid = '$campid'") or die(mysql_error());
				while($row = mysql_fetch_array($query, MYSQL_ASSOC))
				{
          $id = $row['id'];
          mysql_query("DELETE FROM stats WHERE banner_id = '$id'") or die(mysql_error());
        }
        mysql_query("DELETE FROM banners WHERE campid = '$campid'") or die(mysql_error());
        */
		break;
		
		// if banner
		case "banner":	
				$banid = $_POST['id'];
				// delete it
        mysql_query("DELETE FROM stats WHERE banner_id = '$banid'") or die(mysql_error());
				mysql_query("DELETE FROM banners WHERE id = '$banid'") or die(mysql_error());
		break;
	}
}
else
{
	// user not logged in
	header("Location: index.php");
}

?>