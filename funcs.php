<?php
require_once('config2.php');
$function = $_POST['function'];
$chatid = $_POST['chatid'];
$name = $_POST['name'];
if($function=='leave')
{
	mysql_query("INSERT INTO `logs` (`id`, `who`, `message`, `type`)  VALUES (NULL, '".$name."', '".$chatid."', 'chat');");
	mysql_query("INSERT INTO `logs` (`id`, `who`, `message`, `type`)  VALUES (NULL, '".$name."', 'Left chat ".$chatid."', 'regular');");
	
	//mysql_query('DELETE FROM `messages` WHERE `chatid`="'.$chatid.'"');
	mysql_query('DELETE FROM `requests` WHERE `id`="'.$chatid.'"');
}
?>