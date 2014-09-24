<?php

  $q = "CREATE TABLE `users` (".
  "`id` int(11) NOT NULL auto_increment,".
  "`Username` text NOT NULL,".
  "`Password` varchar(32) NOT NULL default '',".
  "`Email` text NOT NULL,".
  "`Rkey` varchar(64) NOT NULL,".
  "PRIMARY KEY  (`id`)".
") ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

  $r1 = mysql_query($q);
  if(!($r1)) { echo "Error Creating User Table"; include 'html/footer.php'; exit; }

  $q = "CREATE TABLE `banners` (".
  "`id` int(10) unsigned NOT NULL auto_increment,".
  "`campid` int(10) unsigned NOT NULL default '0',".
  "`name` text NOT NULL,".
  "`code` text NOT NULL,".
  "`weight` int(10) unsigned NOT NULL default '0',".
  "PRIMARY KEY  (`id`)".
") ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

  $r2 = mysql_query($q);
  if(!($r2)) { echo "Error Creating Banners Table"; include 'html/footer.php'; exit; }
  
  $q = "CREATE TABLE `campaigns` (".
  "`id` int(10) unsigned NOT NULL auto_increment,".
  "`name` varchar(255) NOT NULL default '',".
  "PRIMARY KEY  (`id`)".
") ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

  $r3 = mysql_query($q);
  if(!($r3)) { echo "Error Creating Campaigns Table"; include 'html/footer.php'; exit; }
  
  $q = "CREATE TABLE `stats` (".
  "`banner_id` int(11) NOT NULL default '0',".
  "`count` int(11) NOT NULL default '0',".
  "`dated` date NOT NULL default '0000-00-00'".
") ENGINE=MyISAM DEFAULT CHARSET=latin1;";

  $r4 = mysql_query($q);
  if(!($r4)) { echo "Error Creating Stats Table"; include 'html/footer.php'; exit; }
  
?>