<?php
require_once('../config2.php');
if(isset($_POST['tryit']))
{
	$hid = $_POST['hid'];
	$query = mysql_query("SELECT * FROM requests WHERE `hid`='".$_POST['hid']."'");
	if(mysql_num_rows($query) > 0) {
		//echo '<b>Incoming request...</b><br>';
		while($row = mysql_fetch_assoc($query))
		{
			if($row['operator_handling']=='') {
				echo '<div class="alert alert-error fade in"><a onclick="popupchat('.$row['id'].', myName)" href="#">IP: '.$row['ipaddr']. ' - '.$row['name'].' - No operator in chat</a></div>';
			}
			else
			{
				echo '<div class="alert alert-success fade in"><a onclick="popupchat('.$row['id'].', myName)" href="#">IP: '.$row['ipaddr']. ' - '.$row['name'].' - In chat with: '.$row['operator_handling'].'</a></div>';
			}
			
		}
	}
	else
	{
		echo 'No requests found...';
	}
}
?>