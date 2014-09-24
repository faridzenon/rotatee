<?php

include 'logincheck.php';
include 'html/header.php';

if(isset($_POST['resend']))
{
	$email = trim($_POST['email']);

	// select the Activation code from database
	$query = mysql_query("SELECT * FROM users WHERE Email = '$email' LIMIT 1") or die(mysql_error());
	
	$row = mysql_fetch_array($query);

	$key = $row['Rkey'];

	if(mysql_num_rows($query) > 0)
	{
		// send the mail containing Activation Code
		$send = mail($email , "Link to reset your password" , "You are receiving this email because, you or someone else pretending to be you has requested to reset the password for your Rotatee account..\n\nClick the link below and follow the steps to reset your password:\n".$siteurl."reset.php?id=".$key."\n\nPlease do not reply, this is an automated mailer.\n\n--\nThe Rotatee Team", "FROM: Rotatee<no-reply@Rotatee.com");
		
		if($send)
		{
			// if sent, success message
			echo '
			<h1>Success</h1>
			<div class="ntext">
			<p>The link to reset your password has been successfully sent.</p>
			<p><a href="login.php">Click here</a> to login once you have changed your password.</p></div>';
		} 
		else 
		{
			// else, failure message
			echo '
			<h1>Failed</h1>
			<div class="ntext">
			<p>Your password-resetting email could not be sent. Feel free to hit back and try again.</p></div>';
		}		
	}
	else 
	{
		// email address was not found in database
		echo '
		<h1>Not Found</h1>
		<div class="ntext">
		<p>Sorry, incorrect email. Please enter the email address that you entered during installation.</p></div>';
	}
}
else 
{

?>

<h1>Forgot Password</h1>
<div class="ntext">Enter your registered Email address in the box below and hit Reset. An email containing a link to reset your password will be sent to your email address.

<p>
<form method="post" action="forgot.php">
<center><b>Email (case-sensitive) : </b><input name="email" type="text" class="textBox">&nbsp;<input name="resend" type="submit" id="resend" value="Send"></center>
</form>
</p>
</div>
<?php
}
include 'html/footer.php';
?>