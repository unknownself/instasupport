<?php
session_start();
require_once('../config2.php');
?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- CSS styles -->
		<link rel='stylesheet' type='text/css' href='css/organon-blue.css'>
		
		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="img/icons/favicon.html">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/apple-touch-icon-114-precomposed.html">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/apple-touch-icon-72-precomposed.html">
		<link rel="apple-touch-icon-precomposed" href="img/icons/apple-touch-icon-57-precomposed.html">
		
		<!-- JS Libs -->
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
		<script>window.jQuery || document.write('<script src="js/libs/jquery.js"><\/script>')</script>
		<script src="js/libs/modernizr.js"></script>
		<script src="js/libs/selectivizr.js"></script>
	</head>
	<body class="login-page">
		
		<!-- Main login container -->
		<div class="login-container">
			
			<!-- Login page logo -->
			<h1><a class="brand" href="#">Admin home</a></h1>
			
			<section>
				<?php
			if(!isset($_SESSION['adm_name']))
			{
				if($_POST['submit'])
				{
					$user = htmlentities(strip_tags($_POST['user']));
					$pass = htmlentities(strip_tags($_POST['password']));
					
					$query = mysql_query("SELECT * FROM `admin` WHERE `username`='".$user."'");
					while($row = mysql_fetch_assoc($query))
					{
						$dbuser = $row['username'];
						$dbpass = $row['password'];
						if($user==$dbuser&&$pass==$dbpass)
						{
							$_SESSION['adm_name']=$row['username'];
							$_SESSION['adm_host']=$row['owned_hid'];
							echo "<a href='admin.php'>Logged in. Click here to continue</a>";
						}
					}
					
					/*$query = mysql_query("SELECT * FROM admin WHERE `username`='".$user."'");
					while($row = mysql_fetch_assoc($query))
					{
						$dbuser = $row['username'];
						$dbpass = $row['password'];
						if($user==$dbuser&&$pass==$dbpass)
						{
							$_SESSION['adm_name']=$row['username'];
							$_SESSION['adm_host']=$row['owned_hid'];
							header("Location: admin.php");
						}
						else
						{
							exit('Invalid username/password');
						}
					}*/
					/*while($row = mysql_fetch_assoc($query))
					{
						/*if($user==$row['op_username'] and $pass==$row['op_password'])
						{
							$_SESSION['op_name']=$row['op_username'];
							$_SESSION['op_host']=$row['op_belongsto'];
							header("Location: operator.php");
						}
						else
						{
							exit('invalid username/password');
						}
					}*/
				}
				else
				{
					?>
				<!-- Login form -->
				<form method="post" action="index.php">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="login">Username</label>
							<div class="controls">
								<input id="user" type="text" placeholder="Your username" name="user">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password">Password</label>
							<div class="controls">
								<input id="password" type="password" placeholder="Password" name="password">
								<label class="checkbox">
									<input id="optionsCheckbox" type="checkbox" value="option1"> Remember me
								</label>
							</div>
						</div>
					</fieldset>
					<input class="btn btn-primary btn-alt" value="Log In" type="submit" name="submit">
				</form>
				<?php
				}
			} else {
				echo "<a href='admin.php'>Logged in. Click here to continue</a>";
			}
			?>
				<!-- /Login form -->
				
			</section>
			
			<!-- Login page navigation -->
			<nav>
				<ul>
					<li><a href="mailto:password_recovery@chatbrew.info">Lost password?</a></li>
					<li><a href="../support/">Support</a></li>
					<li><a href="#">Back to page</a></li>
				</ul>
			</nav>
			<!-- Login page navigation -->
			
		</div>
		<!-- /Main login container -->
		
	</body>
</html>