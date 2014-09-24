<?php

include 'config.php';

if(isset($_POST['submit']))
{
	$name = mysql_real_escape_string(trim(urldecode($_POST['name'])));
	$username = mysql_real_escape_string(trim(urldecode($_POST['username'])));
	$email = mysql_real_escape_string(trim(urldecode($_POST['email'])));
	$pass = mysql_real_escape_string(trim(urldecode($_POST['password'])));
	$conf = mysql_real_escape_string(trim(urldecode($_POST['confirm'])));
	$invite = mysql_real_escape_string(trim(urldecode($_POST['invite'])));

	if ((((( empty($name) ) || ( empty($username) ) || ( empty($email) ) || ( empty($pass) )))))
	{
		echo 'regarea|<span class="validation-error">Please fill all the fields</span>';
		exit;
	}

	if((!strstr($email , "@")) || (!strstr($email , ".")))
	{
		echo 'regarea|<span class="validation-error">Invalid Email Address</span>';
		exit;
	}

	$qe = mysql_query("SELECT * FROM users WHERE Email = '$email'") or die(mysql_error());
	
	if(mysql_num_rows($qe) > 0)
	{
		echo 'regarea|<span class="validation-error">Email Address already in use</span>';
		exit;
	}

	$q = mysql_query("SELECT * FROM users WHERE Username = '$username'") or die(mysql_error());
	
	if(mysql_num_rows($q) > 0)
	{
		echo 'regarea|<span class="validation-error">Username already in Use</span>';
		exit;
	}

	if ( $_POST['password'] == $_POST['confirm'] )
	{}
	else
	{
		echo 'regarea|<span class="validation-error">Passwords did not match</span>';
		exit;
	}

	$password = md5($pass);

	$actkey = sha1($username.$password);

	$query = mysql_query("INSERT INTO users (Username, Password, Name, Email, Actkey, Invite) VALUES ('$username','$password','$name','$email','$actkey','$invite')") or die(mysql_error());
	$send = mail($email , "Rotatee : Registration Confirmation" , "Hello ".$name.",\nThank you for registering with Rotatee.com.\n\nYour username and password are below, along with details on how to activate your account.\n\nUsername: ".$username."\nPassword: ".$pass."\n\nClick the link below to activate your account:\n".$siteurl."/activate.php?id=".$actkey."\n\nPlease do not reply, this is an automated mailer.\n\n--\nThe Rotatee Team", "FROM: Rotatee<no-reply@rotatee.com");
 	// $send = mail($email , "Rotatee : Registration Confirmation" , "Hi ".$name.",\nThis is Shrihari from GotChance.com. As requested, i have set you up with an account on Rotatee.com.\n\nYour username and password are below, along with details on how to activate your account.\n\nUser: ".$username."\nPass: ".$pass."\n\nClick the link below to activate your account:\n".$siteurl."/activate.php?id=".$actkey."\n\nDo let me know if you encounter any bugs. Also let me know your suggestions, comments etc.. This is just a pre-release version. All data will be erased before the public launch.\n\n--\nShrihari.S", "FROM: Rotatee<gfxindia@gmail.com>");

	if(($query)&&($send))
	{
		echo 'fullarea|
		<h1>Success</h1>
		<div class="ntext">
		<p>Thank you for registering, you will receive an email soon with your login details and your activation link so that you can activate your account. Make sure you check your Spam/Bulk folder too.</p></div>';
	} else {
		echo 'fullarea|
		<h1>Error</h1>
		<div class="ntext">
		<p>We are sorry, there appears to be a problem with our system at the moment. Please try again later.</p>
		<p>If this problem occurs again, let us know about it.</p></div>';
	}
} 

?>