<?php
session_start();
require_once('../config2.php');
//(!isset($_SESSION['op_name'])) { exit('Security! Arrest this man!'); }
$operator = $_GET['operator'];
$customer = $_GET['customer'];
$name = $_SESSION['smod_name'];
$query = mysql_query('SELECT * FROM requests WHERE `operator_handling`="'.$operator.'" AND `name`="'.$customer.'"');
while($row = mysql_fetch_assoc($query)) {
    $chatId = $row['id'];
}
if(empty($operator) || empty($customer)) { exit(' Error - MYSQL Pony ran away'); }
//if(empty($name) || empty($chatId)) { exit('Error - MYSQL Pony ran away'); }
$query = mysql_query("SELECT * FROM requests WHERE `id`='".$chatId."'"); while($row = mysql_fetch_assoc($query)) { $ipaddr = $row['ipaddr']; $securehash = $row['securehash']; $req_name = $row['name']; }
//mysql_query("INSERT INTO `messages` (`id`, `chatid`, `name`, `message`)  VALUES (NULL, '".$chatId."', 'SYSTEM', '".$name." has entered the chat.');");
mysql_query("INSERT INTO `logs` (`id`, `who`, `message`, `type`)  VALUES (NULL, '".$name."', '".$name." has spyed on chat ".$chatId.".', 'regular');");
?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Spy Dashboard</title>
    <meta name="description" content="">
    <meta name="author" content="Walking Pixels | www.walkingpixels.com">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery Visualize Styles -->
    <link rel='stylesheet' type='text/css' href='css/plugins/jquery.visualize.css'>

    <!-- jQuery FullCalendar Styles -->
    <link rel='stylesheet' type='text/css' href='css/plugins/jquery.fullcalendar.css'>

    <!-- Style -->
    <link rel="stylesheet" href="css/organon-blue.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- JS Libs -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2" type="text/javascript"></script>
    <script src="js/libs/jquery.js"></script>
    <script src="js/libs/modernizr.js"></script>
    <script src="js/libs/selectivizr.js"></script>
    <script>var myName = '<?php echo $_SESSION['smod_name']; ?>';</script>
    <script type="text/javascript">
        var chatid = <?php echo $chatId; ?>;
        function sendMessage()
        {
            $.ajax({
                type: "POST",
                url: "../post.php",
                data: { 'name': '<?php echo $name; ?>', 'message': $("#sendie").val(), 'chatid': chatid, 'type': 'staff'},
                success: function(msg) {
                    refreshChat();
                    $("#sendie").val('');
                    $("#status").html("Message sent.");
                }
            });
        }
        function refreshChat()
        {
            $.ajax({
                type: "POST",
                url: "../chat.php",
                data: { 'chatid': chatid },
                success: function(msg) {
                    $("#status").html("<b>Checking...</b>");
                    $("#chat-area").html(msg);
                }
            });
        }
        setInterval(function(){refreshChat()}, 1000);
        function leavechat()
        {
            $.ajax({
                type: "POST",
                url: "../funcs.php",
                data: { 'function': 'leave', 'chatid': chatid, 'name': myName },
                success: function(msg) {
                    //sendCustomMessage('Operator left the chat room...');
                    //window.location.replace("index.php");
                    window.location.replace("operator.php");
                }
            });
        }
        function notify()
        {
            var whom = $("#transfers option:selected").text();
            $.ajax({
                type: "POST",
                url: "transfers.php",
                data: { 'function': 'transfer', 'towho': whom, 'chatid': chatid, 'fromwho': myName },
                success: function(msg) {

                }
            });
        }
        function loadpreset() {
            var which_preset = $("#cannedreplys option:selected").text();
            sendCustomMessage(which_preset);
        }
        function ban()
        {
            alert('Coming soon');
        }
        function sendCustomMessage(message)
        {
            $.ajax({
                type: "POST",
                url: "../post.php",
                data: { 'name': '<?php echo $name; ?>', 'message': message, 'chatid': chatid },
                success: function(msg) {
                    refreshChat();
                }
            });
        }
        window.onbeforeunload = function () {
            return 'Are you sure you wish to leave?';
        }
        window.setInterval("refreshChat()", 1000);
    </script>
    <script>
        $(document).ready(function(){

            // Tooltips
            $('.user-profile a, .dashboard .badge').tooltip({
                placement: 'top'
            });
            $('.brand, .navbar-search input').tooltip({
                placement: 'bottom'
            });
            $('.main-navigation .badge').tooltip({
                placement: 'right'
            });

        });
    </script>
</head>
<body>

<!-- Main page header -->
<header class="navbar">

    <!-- Navbar style -->
    <div class="navbar-inner">

        <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
        <a class="btn btn-alt btn-primary btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <!-- Sample logo -->
        <a href="operator.php" class="brand" title="Back to homepage">Organon Responsive Twitter Bootstrap Admin Template</a>

        <!-- Everything you want hidden at 940px or less, place within here -->
        <div class="nav-collapse">

            <!-- Header navigation -->
            <nav>
                <ul role="navigation">
                    <li><a href="../smod/"><span class="awe-leaf"></span>SMOD</a></li>
                </ul>
            </nav>
            <!-- /Header navigation -->

            <!-- Logout -->
            <a class="navbar-logout" href="../logout.php"><span class="awe-off"></span>Log out</a>

            <!-- Header search box -->
            <form class="form-search pull-right">
                <input type="text" class="search-query" name="search" title="Enter the search term" placeholder="Search&#8230;" autocomplete="on">
                <button type="submit" class="btn btn-alt btn-primary">Search</button>
            </form>
            <!-- /Header search box -->

        </div>

    </div>
    <!-- /Navbar style -->

</header>
<!-- /Main page header -->

<!-- Full page alert -->
<div class="alert alert-info fade in">
    <button type="button" class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Update</strong> We've put in a new site design!
</div>
<!-- /Full page alert -->

<!-- Main page container -->
<div class="container-fluid">

<!-- Left (navigation) side -->
<div class="sidebar">

    <!-- Sidebar user info -->
    <figure class="user-profile">
        <img alt="John Pixel avatar" src="http://placekitten.com/65/65">
        <figcaption>
            <a href="#"><?php echo $_SESSION['adm_name']; ?></a>
            <em>operator</em>
            <ul class="user-profile-actions">
                <li><a href="#coming_soon" title="Open mailbox"><span class="awe-envelope-alt"></span></a></li>
                <li><a href="../logout.php" title="Logout"><span class="awe-signout"></span></a></li>
            </ul>
        </figcaption>
    </figure>
    <!-- /Sidebar user info -->

    <!-- Sidebar actions
    <ul class="sidebar-actionbar">
        <li><a href="#coming_soon">Mailbox</a></li>
        <li><a href="../logout.php">Log out</a></li>
    </ul>
    <!-- /Sidebar actions -->

    <!-- Main navigation -->
    <nav class="main-navigation" role="navigation">
        <ul>
            <li class="active">
                <a href="operator.php" class="no-submenu"><span class="fam-house"></span>Dashboard</a>
            </li>
            <li>
                <a href="#mailbox.php" class="no-submenu"><span class="fam-application-form"></span>Mailbox</a>
            </li>
            <li>
                <a href="#"><span class="fam-heart"></span>Goodies</a>
                <ul>
                    <li><a href="#">Goodies</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /Main navigation -->

    <!-- Sidebar box: Dark -->
    <section class="sidebar-box sidebar-dark">
        <h2>Visitor Information</h2>
        <p>IP: <?php echo $ipaddr; ?></p>
        <p class="separator"><a href="http://ipinfodb.com/ip_locator.php?ip=<?php echo urlencode($ipaddr); ?>" target="_blank">More info on IP</a></p>
        <p class="separator"></p>
        <a href="#" onClick="window.location.replace('admin.php');" class="btn btn-mini btn-alt btn-primary">Leave chat</a><br>Transfer to:<br>
        <form>
            <select id='transfers'>
                <option>&nbsp;</option>
                <?php
                $query = mysql_query("SELECT * FROM operators WHERE `op_status`='1'");
                while($row = mysql_fetch_assoc($query)) {
                    ?>
                    <option name="<?php echo $row['op_username']; ?>" id="op"><?php echo $row['op_username']; ?></option>
                    <?php
                }
                ?>
            </select>
            <a class="btn btn-mini btn-alt btn-primary" onClick="notify()">Transfer</a><br>
            <p class="separator"><b>Canned replys</b></p>
            <from>
                <select id='cannedreplys'>
                    <option name="canned" id="canned"></option>
                    <?php
                    $query = mysql_query('SELECT * FROM presets');
                    while($row = mysql_fetch_assoc($query)) {
                        echo '<option name="canned" id="canned">'.$row['message'].'</option>';
                    }
                    ?>
                </select>
                <br><input type='button' name='select' value='Select' onclick='loadpreset()'>
            </from>
        </form>
    </section>
    <!-- /Sidebar box: Dark -->

</div>
<!-- /Left (navigation) side -->

<!-- Right (content) side -->
<div class="content-block" role="main">

<!-- Breadcrumb -->
<ul class="breadcrumb">
    <li><a href="#"><span class="awe-home"></span></a></li>
    <li><a href="operator.php">Operators</a></li>
    <li class="active"><a href="#">Chat with <?php echo $ipaddr; ?></a></li>
</ul>
<!-- /Breadcrumb -->

<!-- Page header -->
<!--<article class="page-header">
					<h1>Welcome, <?php echo $_SESSION['op_name']; ?>!</h1>
					<p>Before God we are all equally wise - and equally foolish.</p>
				</article>-->
<!-- /Page header -->

<!-- Dashboard
<ul class="dashboard">

    <!-- Basic dashboard item
    <li>
        <a href="#"><span class="awe-pencil"></span> News</a>
    </li>
    <!-- /Basic dashboard item

    <!-- Dashboard item with submenu/toolbar
    <li class="dashboard-toolbar">
        <a href="#"><span class="awe-flag"></span> Tickets</a>
        <ul class="dashboard-actions">
            <li><a href="#">All</a></li>
            <li><a href="#">New</a></li>
            <li><a href="#">Pending</a></li>
        </ul>
        <span class="badge" title="You have 0 new tickets">0</span>
    </li>
    <!-- /Dashboard item with submenu/toolbar

    <!-- Dashboard item with circular style
    <li class="dashboard-disc">
        <a href="#"><span class="awe-shopping-cart"></span> Payments</a>
    </li>
    <!-- /Dashboard item with circular style

    <li class="dashboard-disc dashboard-toolbar">
        <a href="#"><span class="awe-globe"></span> Visitors</a>
        <ul class="dashboard-actions">
            <li><a href="#">Day</a></li>
            <li><a href="#">Week</a></li>
            <li><a href="#">Month</a></li>
        </ul>
        <span class="badge badge-info" title="You have N/A new alerts">N/A</span>
    </li>
    <li class="dashboard-">
        <span class="sparkline line">1,2,3,7,4,1,8</span>
        <a href="#">Inovices</a>
        <ul class="dashboard-actions">
            <li><a href="#">View</a></li>
            <li><a href="#">Add</a></li>
            <li><a href="#">Update</a></li>
        </ul>
    </li>
    <li class="dashboard-disc">
        <span class="sparkline bar"></span>
        <a href="#">Orders</a>
    </li>
</ul>-->
<!-- /Dashboard -->

<!-- Grid row -->

<div class="row-fluid">

    <!-- Data block -->
    <article class="span12 data-block nested">

        <!-- Data block inner container -->
        <div class="data-container">

            <!-- Data block header -->
            <header>
                <h2>Live Support</h2>

                <!-- Data block header actions -->
                <ul class="data-header-actions single-action">
                    <li>
                        <form class="form-search">
                            <div class="control-group">
                                <div class="controls">
                                    <input class="search-query" type="text" placeholder="Search&#8230;">
                                    <button class="btn btn-alt" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
                <!-- /Data block header actions  -->


            </header>
            <!-- /Data block header -->
            <!-- Data block content -->
            <section>
                <a href="notices.php">All notices</a><p class="separator"></p>
                <br>

                <div id="chat-wrap">
                    <div id="chat-area"></div>
                </div>
                <br>
                <form id="send-message-area" action="">
                    <textarea style="width: 99%; height: 61px;" id="sendie"></textarea> <input type="button" value="Send" onClick="sendMessage()" />
                </form>

                <div id="sec2">

                    <div id="status">

                    </div>
                </div>

            </section>
            <!-- /Data block content -->

        </div>
        <!-- /Data block inner container -->

    </article>
    <!-- /Data block -->

</div>
<!-- /Grid row -->
<?php
/*
<!-- Grid row -->
<div class="row-fluid">

    <!-- Data block -->
    <article class="span4 data-block nested">

        <!-- Data block inner container -->
        <div class="data-container">

            <!-- Data block header -->
            <header>
                <h2><span class="awe-signal"></span> Statistics</h2>

                <!-- Data block header actions -->
                <ul class="data-header-actions">
                    <li><a href="#" class="btn btn-primary btn-alt">Export</a></li>
                </ul>
                <!-- /Data block header actions -->

            </header>
            <!-- /Data block header -->

            <!-- Data block content -->
            <section>

                <!-- Data block statistics widget -->
                <ul class="stats">
                    <li>
                        <strong class="stats-count">N/A</strong>
                        <p>Total Mailbox MSGs</p>
                        <a class="btn btn-alt btn-primary stats-view" href="#" title="View new registrations">View</a>
                    </li>
                </ul>
                <!-- /Data block statistics widget -->

            </section>
            <!-- /Data block content -->

        </div>
        <!-- /Data block inner container -->

    </article>
    <!-- /Data block -->

</div>
<!-- /Grid row -->


<!-- Sample alerts
<div class="alert fade in">
    <button class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Default alert box!</strong> This is default style. Nothing special to see.
</div>
<div class="alert alert-info fade in">
    <button class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Info alert box!</strong> Also a blue one for tips and info highlights.
</div>
<div class="alert alert-warning fade in">
    <button class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Warning alert box!</strong> Best check yo self, you're not looking too good.
</div>
<div class="alert alert-error fade in">
    <button class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Error alert box!</strong> Nice red alert when something goes wrong.
</div>
<div class="alert alert-success fade in">
    <button class="close" data-dismiss="alert"><span class="awe-remove-circle"></span></button>
    <strong>Success alert box!</strong> If you play nice, you will see this one.
</div>
/Sample alerts -->

<!-- Grid row -->
<div class="row-fluid">

    <!-- Data block -->
    <article class="span6 data-block nested">
        <div class="data-container">
            <header>
                <h2>Event logs</h2>
            </header>
            <section>
                <p>Whats going on in cyberspace?</p>
                <p>
                    <span class="emo-confuse" title=".emo-confuse"></span>
                    <span class="emo-cool" title=".emo-cool"></span>
                    <span class="emo-cry" title=".emo-cry"></span>
                    <span class="emo-evilgrin" title=".emo-evilgrin"></span>
                    <span class="emo-fat" title=".emo-fat"></span>
                    <span class="emo-grin" title=".emo-grin"></span>
                    <span class="emo-happy" title=".emo-happy"></span>
                    <span class="emo-mad" title=".emo-mad"></span>
                    <span class="emo-neutral" title=".emo-neutral"></span>
                    <span class="emo-red" title=".emo-red"></span>
                    <span class="emo-roll" title=".emo-roll"></span>
                    <span class="emo-slim" title=".emo-slim"></span>
                    <span class="emo-smile" title=".emo-smile"></span>
                    <span class="emo-surprised" title=".emo-surprised"></span>
                    <span class="emo-tongue" title=".emo-tongue"></span>
                    <span class="emo-unhappy" title=".emo-unhappy"></span>
                    <span class="emo-waii" title=".emo-waii"></span>
                    <span class="emo-wink" title=".emo-wink"></span>
                    <span class="emo-yell" title=".emo-yell"></span>
                </p>

                <div class="entry">
                    <h4 class="entry-header"><span class="fam-database-save"></span> System update #112563 <time datetime="2013-01-04">2013-01-04</time></h4>
                </div>

                <div class="entry">
                    <h4 class="entry-header"><a href="#"><span class="fam-bomb"></span> Security patch</a> <time datetime="2013-01-04">2013-01-04</time></h4>
                </div>

                <div class="entry">
                    <h4 class="entry-header"><a href="#"><span class="fam-flag-blue"></span> Daily dackup completed</a></h4>
                    <p class="entry-details">Posted <time datetime="2013-01-04" title="2013-01-04">today</time> by <a href="#">curtisg</a></p>
                </div>

                <div class="entry">
                    <h4 class="entry-header"><span class="fam-application-xp-terminal"></span> XTerminates under development</h4>
                    <p class="entry-content">XTerminates is a advanced way to find more info about users</p>
                </div>

            </section>
        </div>
    </article>
    <!-- /Data block -->

    <!-- Data block with calendar widget -->
    <article class="span6 data-block nested">
        <div class="data-container">
            <section>
                <div class='fullcalendar'></div>
            </section>
        </div>
    </article>
    <!-- /Data block with calendar widget -->

</div>
<!-- /Grid row -->

</div>
<!-- /Right (content) side -->
*/
?>

</div>
<!-- Main page container -->

<!-- Scripts -->
<script src="js/navigation.js"></script>

<!-- Bootstrap scripts -->
<!--
<script src="js/bootstrap/bootstrap-tooltip.js"></script>
<script src="js/bootstrap/bootstrap-dropdown.js"></script>
<script src="js/bootstrap/bootstrap-button.js"></script>
<script src="js/bootstrap/bootstrap-alert.js"></script>
<script src="js/bootstrap/bootstrap-popover.js"></script>
<script src="js/bootstrap/bootstrap-collapse.js"></script>
<script src="js/bootstrap/bootstrap-transition.js"></script>
-->
<script src="js/bootstrap/bootstrap.js"></script>
<!-- Operator ajax calls -->
<script>
    function opchecker() {
        var tryit = 'yes';
        $.ajax({
            type: "POST",
            url: "../inc/ajax_check.php",
            data: { 'tryit': tryit, 'hid': '<?php echo $_SESSION['smod_host']; ?>' },
            success: function(data)
            {
                $("#status").html(data);
            }
        });
    }
    function checkrequests() {
        var tryit = 'yes';
        $.ajax({
            type: "POST",
            url: "../inc/ajax_opfunc_checkrequests.php",
            data: { 'tryit': tryit, 'hid': '<?php echo $_SESSION['smod_host']; ?>' },
            success: function(data)
            {
                $("#sec").html(data);
            }
        });
    }
    function popupchat(chatId) {
        // we're handling the request. Start up the request functions
        $.ajax({
            type: "POST",
            url: "../inc/ajax_opfunc_tellsystem.php",
            data: { 'handling': myName, 'chatId': chatId },
            success: function(data)
            {
                window.location.replace("operator2.php?action=chat&chatid=" + chatId + "&name=" + myName + "&securehash=" + data);
            }
        });
    }
    function gooffline() {
        $.ajax({
            type: "POST",
            url: "../inc/ajax_opfunc_status.php",
            data: { 'function': 'offline', 'hid': '<?php echo $_SESSION['smod_host']; ?>' },
            success: function(data)
            {
                $("#globalstatus").html("<font color='red'>Changed status to: Offline</font>");
            }
        });
    }
    function goonline() {
        $.ajax({
            type: "POST",
            url: "../inc/ajax_opfunc_status.php",
            data: { 'function': 'online', 'hid': '<?php echo $_SESSION['smod_host']; ?>' },
            success: function(data)
            {
                $("#globalstatus").html("<font color='green'>Changed status to: Online</font>");
            }
        });
    }
</script>
<!-- end operator ajax calls -->

<!-- Block TODO list -->
<script>
    $(document).ready(function() {

        $('.todo-block input[type="checkbox"]').click(function(){
            $(this).closest('tr').toggleClass('done');
        });
        $('.todo-block input[type="checkbox"]:checked').closest('tr').addClass('done');

    });
</script>

<!-- jQuery FullCalendar -->
<script src="js/plugins/fullCalendar/jquery.fullcalendar.min.js"></script>

<script>
    $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('.fullcalendar').fullCalendar({
            header: {
                left: 'title',
                center: '',
                right: 'today month,basicWeek prev,next'
            },
            buttonText: {
                prev: '<span class="awe-arrow-left"></span>',
                next: '<span class="awe-arrow-right"></span>'
            },
            editable: true,
            events: [
                {
                    title: 'Event',
                    start: new Date(y, m, 1),
                    className : 'organon-event organon-event-yellow'
                },
                {
                    title: 'Event',
                    start: new Date(y, m, d-5),
                    end: new Date(y, m, d-2),
                    className : 'organon-event organon-event-green'
                },
                {
                    id: 999,
                    title: 'Event',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false,
                    className : 'organon-event organon-event-blue'
                },
                {
                    id: 999,
                    title: 'Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false,
                    className : 'organon-event organon-event-black'
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    className : 'organon-event organon-event-red'
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    className : 'organon-event organon-event-purple'
                },
                {
                    title: 'Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false,
                    className : 'organon-event'
                }
            ]
        });

    });
</script>

<!-- jQuery Visualize -->
<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="js/plugins/visualize/excanvas.js"></script>
<![endif]-->
<script src="js/plugins/visualize/jquery.visualize.min.js"></script>
<script src="js/plugins/visualize/jquery.visualize.tooltip.min.js"></script>

<script>
    $(document).ready(function() {

        $('table.demo').each(function() {
            var chartType = ''; // Set chart type
            var chartWidth = $(this).parent().width()*0.95; // Set chart width to 90% of its parent

            if(chartWidth < 350) {
                var chartHeight = chartWidth;
            }else{
                var chartHeight = chartWidth*0.25;
            }

            $(this).hide().visualize({
                type: $(this).attr('data-chart'),
                width: chartWidth,
                height: chartHeight,
                colors: ['#3a87ad','#b94a48', '#468847']
            });
        });

    });
</script>

<!-- jQuery SparkLines -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<script>
    $(document).ready(function() {

        // Sample line chart
        $('.sparkline.line').sparkline('html', {
            height: '35px',
            width: '70px',
            lineColor: '#e5e5e5',
            fillColor: '#868585',
            spotColor: '#3a87ad',
            minSpotColor: false,
            maxSpotColor: false,
            spotRadius: 3
        });

        // Sample bar chart
        $('.sparkline.bar').sparkline([17, 23, 18, 14, 18, 19, 13], {
            type: 'bar',
            height: '35px',
            barWidth: '6px',
            barColor: '#3a87ad',
            tooltipFormat: '{{offset:names}}: {{value}} orders',
            tooltipValueLookups: {
                names: {
                    0: 'Monday',
                    1: 'Tuesday',
                    2: 'Wednesday',
                    3: 'Thursday',
                    4: 'Friday',
                    5: 'Saturday',
                    6: 'Sunday'
                }
            }
        });

    });
</script>

</body>
</html>
