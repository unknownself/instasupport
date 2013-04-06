<?php
class WhoAreYou {
	public function __construct($ipaddr) {
		$this->visitorIP = $ipaddr;
        require_once('site.php'); global $config;
		mysql_connect($config['site']['db_host'],$config['site']['db_user'],$config['site']['db_pass']); mysql_select_db($config['site']['db_name']);
	}
	public function checkHID($hid)
	{	
		$this->hid = $hid; // Host ID number assigned by system
		$query = mysql_query("SELECT * FROM hosts WHERE `id`='".$this->hid."'");
		while($row = mysql_fetch_assoc($query))
		{
			$hid_valid = $row['id'];
		}
		if(mysql_num_rows($query)==0)
		{
			exit("Record does not exist");
		}
	}
}
?>