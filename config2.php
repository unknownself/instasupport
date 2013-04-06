<?php error_reporting(0);
require_once('inc/site.php');
global $config;
mysql_connect($config['site']['db_host'],$config['site']['db_user'],$config['site']['db_pass']);
mysql_select_db($config['site']['db_name']);