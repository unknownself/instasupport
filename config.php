<?php error_reporting(0);
require_once('inc/site.php');
// SECURE MYSQL : PDO
global $config;
$dbname = $config['site']['db_name'];
$user = $config['site']['db_user'];
$pass = $config['site']['db_pass'];
$db = new PDO("mysql:host=".$config['site']['db_host'].";dbname=".$dbname."",$user,$pass);
?>