<?php
require_once('config2.php');
$name = $_POST['name'];
$message = htmlspecialchars($_POST['message']);
$chatid = $_POST['chatid'];
if(empty($message)) { }
$type = $_POST['type'];
mysql_query("INSERT INTO `messages` (`id`, `chatid`, `name`, `message`, `reply_type`) VALUES (NULL, '".$chatid."', '".$name."', '".$message."', '".$type."');");
?>