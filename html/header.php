<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Rotatee</title>
<base href="<?php echo $siteurl; ?>" />
<link rel="stylesheet" href="html/style.css" type="text/css" media="screen" />

<script type="text/javascript" src="html/jquery.js"></script>
<script type="text/javascript" src="html/thickbox.js"></script>

<link rel="stylesheet" href="html/thickbox.css" type="text/css" media="screen" />

<script src="html/ajax.js" type="text/javascript"></script>

</head>
<body>
<center>
<div class="wrap">

  <div class="header">
  	<div class="logo"><a href="index.php"><img src="img/logo.gif" /></a></div>
  	<div class="menu">
  	<?php if($logincheck == 1){ ?>
  		<a href="logout.php">Logout</a>
  	<?php }else{ ?>
  		<a href="index.php">Login</a>
  	<?php } ?>
  	</div>
  	<div style="clear: both;"></div>
  </div>
	<div class="modalDialog_transparentDivs" onclick="closeMessage(); return false;"></div>
