<?php
error_reporting(0);
require_once('../config2.php');
$name = $_GET['name'];
mysql_query("INSERT INTO `add_chat` (`id`, `name`, `message`)  VALUES (NULL, 'SYSTEM', $name.' joined the channel.');");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Live Support</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
    <?php

    ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
    <script type="text/javascript">
        function sendMessage()
        {
            $.ajax({
                type: "POST",
                url: "post.php",
                data: { 'name': '<?php echo $name; ?>', 'message': $("#sendie").val() },
                success: function(msg) {
                    refreshChat();
                    $("#sendie").val('');
                    $("#status").html("<b>Message sent.</b>");
                }
            });
        }
        function refreshChat()
        {
            $.ajax({
                type: "POST",
                url: "chat.php",
                data: {},
                success: function(msg) {
                    $("#status").html("<b>Checking...</b>");
                    $("#chat-area").html(msg);
                }
            });
        }
        window.setInterval("refreshChat()", 1000);
    </script>
</head>
<body>
<div id="page-wrap">

    <div id="header">
        <h1><a href="#header">Logo</a></h1>
        <div id="you">Talking as <b><?php echo $name; ?></b></div>
    </div>

    <div id="section">
        <h2><?php echo $name; ?></h2>

        <div id="chat-wrap">
            <div id="chat-area"></div>
        </div>
        <div id="userlist"> Please remember to be respectful or else staff can/will ban you if needed.
        </div>
        <form id="send-message-area" action="">
            <textarea id="sendie" maxlength='200'></textarea> <br /><input type="button" value="Send" onclick="sendMessage()" />
        </form>
        <div id="closed"></div>
        <div id="status">

        </div>
    </div>

</div>
</body>
</html>