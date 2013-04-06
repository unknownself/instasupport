<?php
if(isset($_POST['tryit'])) {
require_once('../config2.php');
$hid = $_POST['hid'];
$query = mysql_query("SELECT * FROM status WHERE `hid`='".$hid."'");
	while($row = mysql_fetch_assoc($query))
	{
		if($row['status']=='1')
		{
			echo '<font color="red">No online agents currently</font>';
		}
		if($row['status']=='2')
		{
			echo '<font color="green">Online</font>';
		}
	}
}
?>