<?php

include 'logincheck.php';

if($logincheck == 1)
{

$campid = $_GET['id'];

	// if a banner is added
	if(isset($_POST['submit']))
	{
		$name = addslashes($_POST['name']);
		$weight = addslashes($_POST['weight']);
		$code = addslashes($_POST['code']);
		
		// add it to the database
		mysql_query("INSERT INTO banners (campid, name, code, weight) VALUES ('$campid','$name','$code','$weight')") or die(mysql_error());
		
		header("Location: view.php?id=$campid");
	}

include 'html/header.php';
echo '<script src="html/swfobject.js" type="text/javascript"></script>';
include 'html/open-flash-chart.php';

$t = 'camps';
include 'html/tabs.php';

/*
$query1 = mysql_query("SELECT t2.Account Account FROM campaigns t1, users t2 WHERE t1.id = '$campid' AND t2.id = t1.userid") or die(mysql_error());

$row2 = mysql_fetch_array($query1, MYSQL_ASSOC);

$acctype = $row2['Account'];

if($acctype == 0)
{
	$query3 = mysql_query("SELECT COUNT(id) FROM campaigns WHERE userid = '$userid' AND id = '$campid' ORDER BY id ASC LIMIT 5") or die(mysql_error());
	
	$limit_count = 0;
	
	$row3 = mysql_fetch_array($query3, MYSQL_ASSOC);

	if($row3['COUNT(id)'] == 1)
	{
		$limit_count = 1;
	}

	if($limit_count == 0)
	{ 
		include 'html/footer.php';
		exit;
	}
}
*/
$r     = mysql_fetch_array(mysql_query("SELECT name FROM campaigns WHERE id = '$campid' ORDER BY id ASC"), MYSQL_ASSOC);

$query = mysql_query("SELECT * FROM banners WHERE campid = '$campid' ORDER BY id ASC") or die(mysql_error());

if($query)
{
	$count = 1;
	
	echo '<h1>Campaign : '.$r['name'].'</h1>';
	
	echo '
	<center>
	<div class="tablediv">
		<div class="rowhead">
			<div class="celldiv count">#</div>
			<div class="celldiv" style="width: 450px;">Banner Name</div>
			<div class="celldiv tcenter" style="width: 59px;">Weight</div>
			<div class="celldiv tcenter" style="width: 93px;">Action</div>
		</div>';
	
	while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{
		$id = $row['id'];
		$name = stripslashes($row['name']);
		$weight = stripslashes($row['weight']);
		$code = htmlentities(stripslashes($row['code']));
		
		echo '
			<div id="banner'.$id.'" class="rowdiv'; if($count%2==0){echo'1';}else{echo '2';} echo'">
				<div class="celldiv count">'.$count.'</div>
				<div id="banner_name'.$id.'">
					<div class="celldiv" style="width: 450px;">'.$name.'</div>
					<div class="celldiv tcenter" style="width: 59px;">'.$weight.'</div>
				</div>
				<div class="celldiv"><a href="#" onClick="edit_banner('.$id.','.$count.'); return false;">Edit</a></div>
				<div class="celldiv"><a href="view.php?id='.$campid.'" onClick="del('.$id.',\'banner\'); document.getElementById(\'banner'.$id.'\').style.display=\'none\'; document.getElementById(\'rep_banner'.$id.'\').style.display=\'none\'; return false;">Delete</a></div>
			</div>';
		
		$count++;
	}
	
	echo '</div></center>'; // close tablediv
}
else 
{
	echo '<b>Error</b>';
}

echo'
<h1><span style="float: left;"><a href="index.php">&laquo;&laquo; Return</a> - <a href="getcode.php?campid='.$campid.'&height=140&width=450" class="thickbox" title="Get Code">Get Code</a></span><a href="addbanner.php?campid='.$campid.'&height=280&width=530" class="thickbox" style="float: right;" title="Add Banner">Add Banner</a><div style="clear: both;"></div></h1>
';


echo '<br/><h1>Statistics</h1>';

echo '<center><div class="tablediv">
		<div class="rowhead">
		<div class="celldiv count">#</div>
		<div class="celldiv" style="width: 450px;">Banner Name</div>
		<div class="celldiv tcenter" style="width: 174px; padding: 2px 10px; font-size: 14px;">Impressions</div>
		<div class="celldiv tcenter" style="width: 59px; padding: 1px 10px; font-size: 12px;">Today</div>
		<div class="celldiv tcenter" style="width: 93px; padding: 1px 10px; font-size: 12px;">Total</div>
		</div>';

	$count = 1;

	$imp_val = array();
	$imp_today = array();
	$name_val = array();
	
	$query_rep = mysql_query("SELECT * FROM banners WHERE campid = '$campid' ORDER BY id ASC") or die(mysql_error());

	while ($row_rep = mysql_fetch_array($query_rep, MYSQL_ASSOC))
	{
		$id = $row_rep['id'];
		$name = $name_val[$count] = stripslashes($row_rep['name']);
		
		$today = mysql_query("SELECT * FROM stats WHERE banner_id = '$id' AND dated = CURDATE()") or die(mysql_error());
		$row_today = mysql_fetch_array($today, MYSQL_ASSOC);
		if(!($row_today['count']))
		{ 
			$imp_today[$count] = 0; 
		} 
		else 
		{
			$imp_today[$count] = $row_today['count'];
		}
		
		$total = mysql_query("SELECT SUM(count) FROM stats WHERE banner_id = '$id'") or die(mysql_error());
		$row_total = mysql_fetch_array($total, MYSQL_ASSOC);
		if(!($row_total['SUM(count)']))
		{ 
			$imp_val[$count] = 0; 
		} 
		else 
		{
			$imp_val[$count] = $row_total['SUM(count)'];
		}
		
		echo '
			<div id="rep_banner'.$id.'"  class="rowdiv'; if($count%2==0){echo'1';}else{echo '2';} echo '">
			<div class="celldiv count">'.$count.'</div>
			<div class="celldiv" style="width: 450px;">'.$name.'</div>
			<div class="celldiv tcenter" style="width: 59px;">'; if($row_today['count']){echo $row_today['count'];}else{echo '0';} echo '</div>
			<div class="celldiv tcenter" style="width: 93px;">'; if($row_total['SUM(count)']){echo $row_total['SUM(count)'];}else{echo '0';} echo '</div>
			</div>';
		
		$count++;
	}

	echo '</div></center>'; // close tablediv
	
	echo '<br/><br/><h1>Pie Charts</h1>';
	echo '<center><div id="flash">';
		
		$g = new graph();

		$g->pie(70,'#505050','{font-size:9px; color: #000000; display: none;}');
		
		$g->width = 350;
		$g->height = 350;
		
		$g->bg_colour = '#FFFFFF';
		
		$g->pie_values( $imp_val, $name_val);
		
		$g->pie_slice_colours( array('#136CA0','#D0E2EC','#AACADD') );
		
		$g->set_tool_tip('#x_label# - #val# Imp.');
		
		$g->title( 'Total', '{font-size:18px; color: #000000}' );
		
		echo '<div style="float: left; width: 50%;">';
		echo $g->render('js');
		echo '</div>';	
			
		$g->pie_values( $imp_today, $name_val );
		
		$g->title( 'Today', '{font-size:18px; color: #000000}' );
		
		echo '<div style="float: left; width: 50%;">';
		echo $g->render('js');
		echo '</div><div style="clear: both;"></div>';


	echo '</div></center>';

}
else
{
include 'html/header.php';

echo 'Not Logged In';
}
include 'html/footer.php';
?>
