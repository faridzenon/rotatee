<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Rotatee</title>
<link rel="stylesheet" href="html/style.css" type="text/css" media="screen" />

<style type="text/css">
.install { width: 100%; }
.install .bigbox
{
	border-top: 1px solid #868473;
	border-left: 1px solid #868473;
	border-right: 1px solid #DEDDD5;
	border-bottom: 1px solid #DEDDD5;
	padding: 4px;
	font-size: 24px;
}
.install .red { border: 2px solid #FF0000; }
</style>

</head>
<body>
<center>
<div class="wrap">

  <div class="header">
  	<div class="logo"><a href="install.php"><img src="img/logo.gif" /></a></div>
  	<div class="menu">

  	</div>
  	<div style="clear: both;"></div>
  </div>

<?php

$err = array();

$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = substr($url, 0, strlen($url) - 11);

if(isset($_POST['install']))
{
  if(empty($_POST['url'])) $err[0] = 1;
  if(empty($_POST['dbhost'])) $err[1] = 1;
  if(empty($_POST['dbname'])) $err[2] = 1;
  if(empty($_POST['dbuser'])) $err[3] = 1;
  if(empty($_POST['dbpass'])) $err[4] = 1;
  if(empty($_POST['username'])) $err[5] = 1;
  if(empty($_POST['pass'])) $err[6] = 1;
  if(empty($_POST['confirm'])) $err[7] = 1;
  if(empty($_POST['email'])) $err[8] = 1;
  
  if(!(count($err)))
  {
    $c = mysql_connect ($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass']);
    $s = mysql_select_db($_POST['dbname']);
    
    if($c && $s)
    {
      $f = file_get_contents("config.php");
      $f = str_replace("SITE_URL", $_POST['url'], $f);
      $f = str_replace("HOST", $_POST['dbhost'], $f);
      $f = str_replace("DB_NAME", $_POST['dbname'], $f);
      $f = str_replace("DB_USER", $_POST['dbuser'], $f);
      $f = str_replace("DB_PASS", $_POST['dbpass'], $f);
      file_put_contents("config.php", $f);
    }
    else
    {
			echo '<script>alert("Error connecting to the database. Check the database details.");</script>';
			echo '<script>history.back(1);</script>';
			exit;
    }
    
    include('config.php');
    include('installer.php');
    
		$pass = mysql_real_escape_string(trim($_POST['pass']));
		$conf = mysql_real_escape_string(trim($_POST['confirm']));
		$username = mysql_real_escape_string(trim($_POST['username']));
		$email = mysql_real_escape_string(trim($_POST['email']));
		
		if ($pass != $conf)
		{
			echo '<script>alert("Your passwords were not the same, please enter the same password in each field.");</script>';
			echo '<script>history.back(1);</script>';
			exit;
		}
		$password = md5($pass);
		
		$key = sha1($username.$password);
    
    $r = mysql_query("INSERT INTO users (Username, Password, Email, Rkey) VALUES ('$username','$password','$email','$key')");
    if(!($r)) { echo "Error Creating Admin Account"; include 'html/footer.php'; exit; }
    
    echo '<h1>Rotatee Installed Successfully</h1>';
    echo '<div style="font-size: 20px; padding: 5px 25px; line-height: 34px;">Congrats dude.. Rotatee has been installed successfully.. Now you can head over to <a href="'.$siteurl.'">your new installation</a> and start creating campaigns. If you experience any problems, don\'t worry, we are <a href="http://rotatee.com/">right here</a>.</div>';
    include 'html/footer.php';
    
    @unlink("installer.php");
    @unlink("install.php");
    
    exit;
  }
}

?>

<form action="install.php" method="post">

	<table border="0" cellpadding="20" cellspacing="0" style="font-size: 20px; margin: 10px;" class="install">
		<tr>
      <td colspan="2" align="left">
        <h1>Installation Settings</h1>
      </td>
    </tr>
		<tr>
			<td width="45%" align="right">Installation URL<br /><small>change if the detected URL is wrong</small></td>
			<td width="55%"><input name="url" type="text" id="url" class="bigbox<?php if(isset($err[0])) echo ' red'; ?>" value="<?php echo $url; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Database Host<br /><small>99% you need not have to change this</td>
			<td><input name="dbhost" type="text" id="dbhost" class="bigbox<?php if(isset($err[1])) echo ' red'; ?>" value="localhost" /></td>
		</tr>
		<tr>
			<td align="right">Database Name</td>
			<td><input name="dbname" type="text" id="dbname" class="bigbox<?php if(isset($err[2])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Database Username</td>
			<td><input name="dbuser" type="text" id="dbhost" class="bigbox<?php if(isset($err[3])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Database Password</td>
			<td><input name="dbpass" type="password" id="dbpass" class="bigbox<?php if(isset($err[4])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
      <td colspan="2" align="left">
        <h1>Admin Account Settings</h1>
      </td>
    </tr>
    <tr>
			<td align="right">Username</td>
			<td><input name="username" type="text" id="username" class="bigbox<?php if(isset($err[5])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Password</td>
			<td><input name="pass" type="password" id="pass" class="bigbox<?php if(isset($err[6])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Confirm Password</td>
			<td><input name="confirm" type="password" id="confirm" class="bigbox<?php if(isset($err[7])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
			<td align="right">Email Address<br /><small>just in case you forgot your password</small></td>
			<td><input name="email" type="text" id="email" class="bigbox<?php if(isset($err[8])) echo ' red'; ?>" /></td>
		</tr>
		<tr>
      <td colspan="2" align="center">
        <input name="install" type="submit" value="Install Rotatee" style="padding: 4px; font-size: 24px;" />
      </td>
    </tr>
	</table>

</form>

	<div class="footer">
		Powered by <a href="http://rotatee.com/">Rotatee</a>
	</div>
</div>
</center>
</body>
</html>
