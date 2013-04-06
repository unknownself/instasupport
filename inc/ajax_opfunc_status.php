<?php
require_once('../config2.php');
$function = $_POST['function'];
$hid = $_POST['hid'];
if($function=='offline')
{
	mysql_query("UPDATE  `chatv2`.`status` SET  `status` =  '1' WHERE  `status`.`hid` =  '".$hid."' LIMIT 1 ;");
}
if($function=='online')
{
	mysql_query("UPDATE  `chatv2`.`status` SET  `status` =  '2' WHERE  `status`.`hid` =  '".$hid."' LIMIT 1 ;");
}
?>