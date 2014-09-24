<?php

include 'logincheck.php';

if($logincheck == 1)
{
	// if a Campaign if added...
	if(isset($_POST['name']))
	{
		$name = trim(addslashes($_POST['name']));
		
		// add the Campaign right away
		$query = mysql_query("INSERT INTO campaigns (name) VALUES ('$name')") or die(mysql_error());
		header("Location: index.php");
	}
	
	include 'html/header.php';
	
	// mention the active tab
	$t = 'camps';
	include 'html/tabs.php';

	// select the user's Campaigns from Database
	$query = mysql_query("SELECT * FROM campaigns ORDER BY id ASC") or die(mysql_error());
	
	if($query)
	{
		$count = 1;
			
		echo '<center><div class="tablediv">
			<div class="rowhead">
				<div class="celldiv count">#</div>
				<div class="celldiv" style="width: 414px;">Campaign Name</div>
				<div class="celldiv tcenter" style="width: 206px;">Action</div>
			</div>';
		
		// display the campaigns one by one
		while ($row = mysql_fetch_array($query, MYSQL_ASSOC))
		{
			$id = $row['id'];
			$name = $row['name'];
			
			echo '
				<div id="camp'.$id.'" class="rowdiv'; if($count%2==0){echo'1';}else{echo '2';} echo'">
					<div class="celldiv count">'.$count.'</div>
					<div class="celldiv" style="width: 414px;" id="name'.$id.'"><a href="view.php?id='.$id.'">'.$name.'</a></div>
					<div class="celldiv"><a href="getcode.php?campid='.$id.'&height=140&width=450" class="thickbox" title="Get Code">Get Code</a></div>
					<div class="celldiv"><a href="#" onClick="rename_camp('.$id.'); return false;" title="Rename">Rename</a></div>
					<div class="celldiv"><a href="" onClick="del('.$id.',\'camp\'); document.getElementById(\'camp'.$id.'\').style.display = \'none\';  return false;" title="Delete">Delete</a></div>
				</div>
				';
				/* Effect.Fade(\'camp'.$id.'\'); */
			
			$count++;
		}
		
		echo '</div></center>';
	} 
	else 
	{
		// error, if there is any problem with selecting the user's Campaigns
		echo '<b>Error</b>';
	}
	
	// display the Create New Campaign link
	echo'
	<h1 style="text-align: right;"><a href="create.php?height=45&width=300" class="thickbox" title="Create New Campaign">Create New Campaign</a></h1>
	';
}
else
{
  if(isset($_POST['login']))
  {
  	$username = trim(addslashes($_POST['username']));
  	$password = md5(trim($_POST['password']));
  
  	// check if a user with this USERNAME and PASSWORD exists
  	$query = mysql_query("SELECT * FROM users WHERE id = 1 AND Username = '$username' AND Password = '$password' LIMIT 1") or die(mysql_error());
  	
  	$row = mysql_fetch_array($query);
  
  	// now we check if they are activated
  	if(mysql_num_rows($query) > 0)
  	{
  			// the current time
  			$time = time();
  			
  			// the username and password
  			$cookie_data = $username.'-'.$password;
  			
  			// if checked, remember the user
  			if(isset($_POST['remember']))
  			{
  				setcookie("Rotatee", $cookie_data, time()+1296000);
  			}
  			else
  			{
  				setcookie("Rotatee", $cookie_data);
  			}
  			
  			header("Location: index.php");
  			exit;
  	} 
  	else 
  	{
  		include 'html/header.php';
  		
  		// username and password do no match
  		echo '
  		<h1>Error</h1>
  		<div class="ntext">
  		There was an error processing your login, it appears that your username and/or password was incorrect. Please try again.<br/>
  		<a href="forgot.php">Click here</a> if you forgot your password.</div>';
  	}
  }
  else 
  {
  include 'html/header.php';
  
  ?>
  <h1>Login to Rotatee</h1>
  <form method="post" action="index.php">
  <table width="300px" align="center" border="0" cellpadding="5" cellspacing="0" style="font-size: 18px;">
  <tr>
  <td align="right">Username</td>
  <td><input name="username" type="text" id="username" class="bigbox" /></td>
  </tr>
  <tr>
  <td align="right">Password</td>
  <td><input name="password" type="password" id="password" class="bigbox" /></td>
  </tr>
  <tr>
  <td align="center" colspan="2">
  <input name="remember" type="checkbox" id="remember" value="ON" />
  <label for="remember">Remember me</label>
  </td>
  </tr>
  <tr>
  <td align="center" colspan="2">
  <input name="login" type="submit" id="login" value="Login" style="font-size: 18px;" />
  </td>
  </tr>
  </table>
  <p align="center"><a href="forgot.php">Forgot Passward ?</a></p>
  </form>
  
  <?php
  }
}
include 'html/footer.php';
?>