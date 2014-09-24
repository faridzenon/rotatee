<?php 
$time = time(); 

if (isset($_COOKIE['Rotatee']))
{ 
  setcookie ("Rotatee", "", $time - 3600);
  header("Location: index.php");
} 
?>