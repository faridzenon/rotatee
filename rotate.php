<?php

function jsspecialchars($string) 
{
	$string = preg_replace("/\r*\n/","\\n",$string);
	$string = preg_replace("/\//","\\\/",$string);
	$string = preg_replace("/\"/","\\\"",$string);
	$string = preg_replace("/'/"," ",$string);

	return $string;
}

include 'config.php';

// get the campaign ID
$campid = $_GET['campid'];

// get the number of banners to show
$s = $_GET['s'];

// get the name of the class to be used
$c = $_GET['c'];

if($s == 1) // if to show only one banner
{

	$query = mysql_query("SELECT * FROM banners WHERE campid = '$campid' ORDER BY id ASC") or die(mysql_error());
	
	$code = array();
	$weight = array();
	
	$i = 0;
	
	while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{
		$code[$i] = $row['code'];
		$weight[$i] = $row['weight'];
		$id[$i] = $row['id'];
		
		$i++;
	}
	
	$total = array_sum($weight);
	
	$num = rand(1,$total);
	
	$sum = 0;
	
	$j = 0;
	
	while($j<$i)
	{	
		$factor = $sum + $weight[$j];
		
		if($num > $sum && $num <= $factor)
		{ 
			$code_disp = jsspecialchars(stripslashes($code[$j]));
			
			Header("content-type: application/x-javascript");
			
			echo 'document.write("<div class=\"'.$c.'\">");';
			
			echo 'document.write("'.$code_disp.'");';
			
			echo 'document.write("</div>");';


			$dated = date("Y-m-d");
			$query2 = mysql_query("SELECT * FROM stats WHERE banner_id = '$id[$j]' AND dated = CURDATE()");
			
			if(mysql_num_rows($query2) > 0)
			{
				$row2 = mysql_fetch_row($query2);
				$count = $row2[1] + 1;
				
				$query2 = mysql_query("UPDATE stats SET count = '$count' WHERE banner_id = '$id[$j]' AND dated = CURDATE()") or die(mysql_error());
			}
			else
			{
				$query2 = mysql_query("INSERT INTO stats (banner_id, count, dated) VALUES ('$id[$j]','1', CURDATE())") or die(mysql_error());
			}

			exit;
		}
		
		$sum = $factor;
		
		$j++;
	}
	
}
else // if s != 1, (i.e) if to show more than 1 banner
{

	function rot_rand($min, $max, $num) 
	{
		if ($min<$max && $max-$min+1 >= $num && $num>0) 
		{
			$random_nums = array();
			$i=0;
			while($i<$num) 
			{
				$rand_num = rand($min, $max);
				if (!in_array($rand_num, $random_nums)) 	
				{
					$random_nums[] = $rand_num;
					$i++;
				 }
			}
			return $random_nums;
		} 
		else 
		{
			return false;
		}
	}	
	
	$query = mysql_query("SELECT * FROM banners WHERE campid = '$campid' ORDER BY id ASC") or die(mysql_error());
	
	$i = 0;
	
	while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{
		$code[$i] = $row['code'];
		$id[$i] = $row['id'];
		
		$i++;
	}
	
	$count2 = count($code);
	
	if($s == 0)
	{
		$nums = rot_rand(0,$count2-1,$count2);
	}
	elseif($s > 1)
	{
		$nums = rot_rand(0,$count2-1,$s);
		$count2 = $s;
	}
	
	Header("content-type: application/x-javascript");
	
	echo 'document.write("<div class=\"'.$c.'\">");';
	
	for($j = 0; $j < $count2; $j++)
	{
		$code_disp = jsspecialchars(stripslashes($code[$nums[$j]]));
		
		echo 'document.write("<span class=\"'.$c.'_elmt\">'.$code_disp.'</span>");';


		$dated = date("Y-m-d");
		$theid = $id[$nums[$j]];
		$query2 = mysql_query("SELECT * FROM stats WHERE banner_id = '$theid' AND dated = CURDATE()");
		
		if(mysql_num_rows($query2) > 0)
		{
			$row2 = mysql_fetch_row($query2);
			$count = $row2[1] + 1;
			
			$query2 = mysql_query("UPDATE stats SET count = '$count' WHERE banner_id = '$theid' AND dated = CURDATE()") or die(mysql_error());
		}
		else
		{
			$query2 = mysql_query("INSERT INTO stats (banner_id, count, dated) VALUES ('$theid','1', CURDATE())") or die(mysql_error());
		}

	}
	
	echo 'document.write("</div>");';

}

?>