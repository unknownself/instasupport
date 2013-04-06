<?php
require_once('../config2.php');
$chatid = $_POST['chatid'];
$to = $_POST['towho'];
$from = $_POST['fromwho'];
mysql_query('INSERT INTO `transfer`(`id`, `to`, `from`, `chatid`) VALUES (NULL, "'.$to.'", "'.$from.'", "'.$chatid.'")');
?>