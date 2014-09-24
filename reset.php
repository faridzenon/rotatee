<?php

include 'logincheck.php';
include 'html/header.php';

if(isset($_POST['submit']))
{
	$pass = addslashes(trim($_POST['password']));
	$conf = addslashes(trim($_POST['confirm']));
	$id = $_POST['id'];

	if ($_POST['password'] != $_POST['confirm'])
	{
		echo '<script>alert("Your passwords were not the same, please enter the same password in each field.");</script>';
		echo '<script>history.back(1);</script>';
		exit;
	}

	$password = md5($pass);

	$do = mysql_query("UPDATE users SET Password = '$password' WHERE Rkey = '$id' LIMIT 1") or die(mysql_error());

	if($do)
	{
		echo '
		<h1>Success</h1>
		<div class="ntext">
		<p>Your password has been successfully reset.</p>
		<p><a href="login.php">Click here</a> to login now.</p></div>';
	} 
	else 
	{
		echo '
		<h1>Error</h1>
		<div class="ntext">
		<p>We are sorry, there appears to be a problem with resetting your password. Please try again later.</p></div>';
	}
}
else
{
	$id = $_GET['id'];

	$query = mysql_query("SELECT * FROM users WHERE Key = '$id' LIMIT 1") or die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if(mysql_num_rows($query) > 0)
	{
		echo '
		<h1>Reset Password</h1>
		<div class="ntext">
			<form action="'.$_SERVER['PHP_SELF'].'" method="post">
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td align="right">New Password</td>
						<td><input name="password" type="password" id="password" class="textbox" /></td>
					</tr>
					<tr>
						<td align="right">Confirm New Password </td>
						<td><input name="confirm" type="password" id="confirm" class="textbox" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input name="id" type="hidden" id="id" value="'.$id.'" />
							<input name="submit" type="submit" value="Submit" style="font-size: 17px;" />
						</td>
					</tr>
				</table>
			</form>
		</div>';
	} 
	else 
	{
		echo '
		<h1>Not Found</h1>
		<div class="ntext">
		<p>Sorry, the page you are looking for was not found.</p>
		<p><a href="forgot.php">Click here</a> to reset your password if you have lost it.</p></div>';
	}
} //if the post is not subtmitted close

include 'html/footer.php';

?>