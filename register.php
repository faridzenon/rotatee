<?php

include 'logincheck.php';
include 'html/header.php';

if(isset($_POST['invite']))
{ $invite = strtolower($_POST['invite']); }
else
{ echo '<h1>No Invite Code Entered</h1>'; exit; }

$row = mysql_fetch_array(mysql_query("SELECT Count(id) FROM users WHERE Invite = '$invite'"));
$count = $row['Count(id)'];

/* when you remove the invite feature, please update the GotBanners plugin page on Gotchance.com */

switch($invite)
{
	case "brandon": if($count >= 1000) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "garcya": if($count >= 1000) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "andaka": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "maelkool": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "maisblogs": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "ollieparsley": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "techjuicer": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "webjuice": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "siteguide": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "makeuseof": if($count >= 2500) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "webappers": if($count >= 1001) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "techcrunch": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "mashable": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "centernetworks": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "readwriteweb": if($count >= 300) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "gotchance": if($count >= 1000) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "johnchow": if($count >= 200) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "bloggingexperiment": if($count >= 200) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "johntp": if($count >= 1000) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "shoemoney": if($count >= 200) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "problogger": if($count >= 1000) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "netbusinessblog": if($count >= 200) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "carlocab": if($count >= 250) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "techfold": if($count >= 250) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "jeffro2pt0": if($count >= 200) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	case "darin": if($count >= 250) { echo '<h1>Invite Code Expired</h1>'; exit; } break;
	default: echo '<h1>Invalid Invite Code</h1>'; exit; break;
}

echo '<script language="javascript" src="html/register.js"></script>';

?>
<h1>Register</h1>
<div id="fullarea">
<form name="regform" id="regform" onsubmit="register('<?php echo $invite; ?>');" >
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-size: 18px;">
<tr>
<td align="right">Name </td>
<td><input name="name" type="text" id="name" class="bigbox" /></td>
</tr>
<tr>
<td align="right">Email Address </td>
<td><input name="email" type="text" id="email" class="bigbox" /></td>
</tr>
<tr>
<td align="right">Username </td>
<td><input name="username" type="text" id="username" class="bigbox" /></td>
</tr>
<tr>
<td align="right">Password </td>
<td><input name="password" type="password" id="password" class="bigbox" /></td>
</tr>
<tr>
<td align="right">Confirm Password </td>
<td><input name="confirm" type="password" id="confirm" class="bigbox" /></td>
</tr>
<tr>
<td colspan="2" align="center">
<div id="regarea" style="font-size: 15px; margin-bottom: 10px;"></div>
<input type="button" value="Register" name="reg" onclick="register('<?php echo $invite; ?>');" style="font-size: 18px;" />
</td>
</tr>
</table>
</form>
</div>

<?php 

include 'html/footer.php';

?>
