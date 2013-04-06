<?php
require_once('config2.php');
$chatid = $_POST['chatid'];
$query = mysql_query("SELECT * FROM messages WHERE `chatid`='".$chatid."'");
while($row = mysql_fetch_assoc($query))
{
	$message = $row['message'];
	if(empty($message)) { echo "<b><font color='black'>".$row['name']."</b> entered a blank message.</font><br>"; }
	/*else if(strpos(":)", $message) !== false)
	{
		$message = str_replace(array(':)'), array('<img src="smiles/smile.gif" border="0">'), $message);
		echo "<b><font color='black'>".$row['name']."</b> says: <br> <font color='black'>".$message."</font><br>";
	} else if(strpos(":(", $message) !== false)
	{
		$message = str_replace(array(':(', '):'), array('<img src="smiles/sad.png" border="0">', '<img src="smiles/sad.png" border="0">'), $message);
		echo "<b><font color='black'>".$row['name']."</b> says: <br> <font color='black'>".$message."</font><br>";
	} else if(strpos("):", $message) !== false)
	{
		$message = str_replace(array('):'), array('<img src="smiles/sad.png" border="0">'), $message);
		echo "<b><font color='black'>".$row['name']."</b> says: <br> <font color='black'>".$message."<br></font>";
	}*/
	else
	{   if($row['reply_type']=='regular') {
        $whatfont = 'black';
    } else {
        $qfast = mysql_query('SELECT * FROM `ranks` WHERE `who`="'.$row['name'].'"');
        while($raw = mysql_fetch_assoc($qfast)) {
            $rank = $raw['rank'];
            if($rank == 'Tech Mod') {
                $whatfont = '#00FFFF';
            } elseif($rank == 'Forum Mod') {
                $whatfont = '#008000';
            } elseif($rank == 'Super Mod') {
                $whatfont = '#FFFF00';
            } elseif($rank == 'Admin') {
                $whatfont = '#F00000';
            }
        }
    }
		echo "<b><font color='".$whatfont."'>".$row['name']."</font></b> says: <br><font color='black'>".$row['message']."<br></font>";
	}
}
?>