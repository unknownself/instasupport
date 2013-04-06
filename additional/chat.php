<?php
require_once('../config2.php');
$query = mysql_query("SELECT * FROM add_chat");
while($row = mysql_fetch_assoc($query))
{
    if(empty($name)) { $name='Guest'; }
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
    else {
        echo "<b><font color='black'>".$row['name']."</font></b> says: <br><font color='black'>".$row['message']."<br></font>";
    }
}
?>