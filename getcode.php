<link rel="stylesheet" href="html/style.css" type="text/css" media="screen" />
<?php

include 'logincheck.php';

if($logincheck == 1)
{
	// get the Campaign ID
	$campid = $_GET['campid'];

	$query = mysql_query("SELECT COUNT(id) FROM banners WHERE campid = '$campid'") or die(mysql_error());
	
	$row = mysql_fetch_array($query, MYSQL_ASSOC);
	
	echo '
	<script type="text/javascript">
	function Process(selection)
	{
		var codebox = document.getElementById("code");
	';
	echo '	var thecode = \'<script type="text/javascript" src="'.$siteurl .'/rotate.php?campid='.$campid.'&s=\'+selection+\'&c=rotatee"></\';';
	
	echo '
		codebox.code.value = thecode+\'script>\';
	}
	</script>';
	
	// display the corresponding code
	echo'
	<div style="margin: 10px;">
		<form name="nofb">
			Show <select name="no" onchange="Process(this.options[this.selectedIndex].value);">';
			
			for($i = 1; $i <= $row['COUNT(id)']; $i++)
			{
				echo'	<option value="'.$i.'">'.$i.'</option>';
			}
			echo '
					<option value="0">All</option>
				</select> banners at a time
		</form>
		
		<form name="code" id="code" style="margin-top: 10px;">
		<textarea onClick="this.form.code.focus();this.form.code.select();" readonly="1" name="code" rows="3" cols="50"><script type="text/javascript" src="'.$siteurl .'rotate.php?campid='.$campid.'&s=1&c=rotatee"></script>
</textarea>
		</form>
	</div>';
}
else
{
	echo '<meta http-equiv="refresh" content="0;url=index.php" />';
}

?>
