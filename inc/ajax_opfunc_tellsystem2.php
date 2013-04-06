<?php
require_once('../config2.php');
if(isset($_POST['handling']) and isset($_POST['chatId']))
{
	$handledBy = $_POST['handling']; // who is handling it?
	$chatId = $_POST['chatId']; // chat ID to update.
	mysql_query("UPDATE  `requests` SET  `operator_handling` =  '".$handledBy."' WHERE  `requests`.`id` =".$chatId.";");
	// add item to chatlog
	$file = "chatlog-".$chatId.".txt";
	$chatlogdir = "chatlogs";
	mysql_query("DELETE FROM `transfer` WHERE `transfer`.`chatid` = ".$chatId."");
	$query = mysql_query("SELECT * FROM `requests` WHERE `id`='".$chatId."'");
	while($row = mysql_fetch_assoc($query))
	{
		echo $row['securehash'];
	}
}
?>