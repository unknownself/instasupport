<?php
require_once('../config.php');
$me = $_POST['me'];
$query = $db->query('SELECT * FROM transfer WHERE `to`="'.$me.'"');
if($query->rowCount()!=0) {
	foreach($query as $row) {
		echo '<a href="#" onclick="transferSuccess('.$row['chatid'].')"><b>Transfer Request</b> from '.$row['from'].'</a><br>';
	}
}
?>