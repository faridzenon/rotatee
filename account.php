<?php

include 'logincheck.php';

// if the user has logged in
if($logincheck == 1)
{
	// select the user

	$query = mysql_query("SELECT * FROM users WHERE id = '$userid'") or die(mysql_error());	
	
	$row = mysql_fetch_array($query);

	$email = $row['Email'];
	
	// if user changes name or email
	if(isset($_POST['email_change']))
	{
		$email = addslashes($_POST['Email']);		
		
		$qe = mysql_query("SELECT * FROM users WHERE Email = '$email'") or die(mysql_error());
	
    // For Rotatee MU.. Not really needed now..
		if(mysql_num_rows($qe) > 0)
		{
			echo '<script>alert("The email address that you entered is already in use.");</script>';
			echo '<script>history.back(1);</script>';
			exit;
		}		

		// if the email has not been changed
		if($email != $row['Email'])	$query = mysql_query("UPDATE users SET Email = '$email' WHERE id = '$userid' LIMIT 1") or die(mysql_error());
	}

	if(isset($_POST['pass_change']))
	{
		$pass = addslashes(trim($_POST['password']));
		$conf = addslashes(trim($_POST['confirm']));

		if ($_POST['password'] != $_POST['confirm'])
		{
			echo '<script>alert("Your passwords were not the same, please enter the same password in each field.");</script>';
			echo '<script>history.back(1);</script>';
			exit;
		}

		$password = md5($pass);

		$do = mysql_query("UPDATE users SET Password = '$password' WHERE id = '$userid' LIMIT 1") or die(mysql_error());
	}

	include 'html/header.php';
	// mention the active tab
	$t = 'acc';
	include 'html/tabs.php';

	// display the Account Edit form...
	echo '
		<h1>Change Email Address</h1>
		<div style="font-size: 17px; margin: 15px;">
			<form name="acc_edit" action="'.$_SERVER['PHP_SELF'].'" method="post">
				<div style="width: 40%; float: left;">
					Email : <input name="Email" type="text" id="Email" class="bigbox" value="'.$email.'" />
				</div>
				<div style="float: left;">
					<input name="email_change" type="submit" id="email_change" style="font-size: 18px;" value="Change"/>
				</div>
				<div style="clear: both;"></div>
			</form>
		</div><br/>';

	// display the password Edit form...
	echo '
		<h1>Change Password</h1>
		<div style="font-size: 17px; margin: 15px;">
			<form name="pass_edit" action="'.$_SERVER['PHP_SELF'].'" method="post">
				<div style="width: 41%; float: left;">
					Password : <input name="password" type="password" id="password" class="bigbox" />
				</div>
				<div style="width: 41%; float: left;">
					Confirm : <input name="confirm" type="password" id="confirm" class="bigbox" />
				</div>
				<div style="float: left;">
					<input name="pass_change" type="submit" id="pass_change" style="font-size: 18px;" value="Change"/>
				</div>
				<div style="clear: both;"></div>
			</form>
		</div>';
}
else
{
	header("Location: index.php");
}

include 'html/footer.php';
?>
