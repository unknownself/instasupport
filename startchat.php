<?php
session_start();
require_once('config.php');
$hid = $_GET['hid'];
if(!isset($_GET['hid']) || empty($hid))
{
	exit('HID Read Error -> Notified Administrator');
}
else
{
	require_once('inc/who_class.php');
	$who = new WhoAreYou($_SERVER['REMOTE_ADDR']);
	$who->checkHID($hid);
	//$who->checkBans();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Live Support</title>
<link rel="stylesheet" type="text/css" href="main.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
<script>
	function changeScreenSize(w,h)
	{
		window.resizeTo(w,h);
		chrome.windows.update(w,h);
	}
	function checkresize()
	{
		if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
		{
			var t = setTimeout("resize()", 200);
		}
		else
		{
			resize();
		}
	}
		
	function resize() {
		var innerWidth = window.innerWidth || document.documentElement.childWidth ||document.body.childWidth;
		var innerHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var targetWidth = 640;
		var targetHeight = 530;
		window.resizeBy(targetWidth-innerWidth, targetHeight-innerHeight);
	}
</script>
</head>
<body onload="checkresize()">
    <div id="page-wrap"> 
    
    	<div id="header">
        	<h1><a href="#header">Logo</a></h1>
        </div>
        
    	<div id="section">
        	<p>To help us serve you better, please enter some information before starting the chat.</p>
			<form action="request.php" method="POST">
				Name<br /> <input type="text" name="name" value="" style="width:100%;" /><br />
				Email<br /> <input type="text" name="email" style="width:100%;" /><br />
				Department<br />
				<select name="department">
					<?php
						$sql = "SELECT * FROM departments WHERE `hid`='".$hid."'";
						foreach ($db->query($sql) as $row) {
							echo "<option name='".$row['name']." value='".$row['name']."'>".$row['name']."</option>";
						}
					?>
				</select><br />
				Message<br /><textarea name="message" style="margin: 0px; height: 128px; width: 100%;"></textarea><br />
				<input type="hidden" name="hid" value="<?php echo $hid; ?>" /><br />
				<input type="submit" name="submit" value="Start Chat" />
			</form>
			<div id="userlist2">
				<b></b>
			</div>
        </div>
		<div id="sec2">
			<div id="status">
				
        	</div>
			<!--<b>Copyright &copy; 2012 <a href="http://chatbrew.info/" style="color:white;">ChatBrew</a></b>-->
		</div>
		<!-- example live support online -->
			<!-- coming soon -->
		<!-- end example -->
    </div>
	<script>
	
	function opchecker() {
	var tryit = 'yes';
	$.ajax({
		type: "POST",
		url: "inc/ajax_check.php",
		data: { 'tryit': tryit, 'hid': '<?php echo $hid; ?>' },
		success: function(data)
		{
			if(data=='<font color="red">No online agents currently</font>')
			{
				$("#section").html(data);
				//$("#status").html('');
			} else {
				//$("#status").html(data);
			}
		}
	});
}
	setInterval(function(){opchecker()},3000);
	setTimeout("opchecker()",1);
</script>
</body>
</html>
<?php
}
?>