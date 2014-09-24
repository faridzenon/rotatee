<?php

$l = @mysql_connect ( "HOST" , "DB_USER" , "DB_PASS" ) or die("<h1>Error in connecting to database</h1>");
@mysql_select_db( "DB_NAME" ) or die("<h1>Error in connecting to database</h1>");

$siteurl = 'SITE_URL'; // Enter the exact destination where the script will be used.  include http://

?>