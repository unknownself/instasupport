<?php
require_once('../config2.php');
$name = $_POST['name'];
$message = htmlspecialchars($_POST['message']);
if(empty($message)) { }
if(empty($name) || !isset($name)) {
    $name = 'Guest';
    $message = 'I cannot send messages, since I am a guest and not a authorized user.';
}
mysql_query("INSERT INTO `add_chat` (`id`, `name`, `message`) VALUES (NULL, '".$name."', '".$message."');");
?>