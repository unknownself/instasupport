<?php error_reporting(0);
require_once('../config.php');
/**
 * File: index.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Installer</title>

    <style type="text/css">

        ::selection{ background-color: #E13300; color: white; }
        ::moz-selection{ background-color: #E13300; color: white; }
        ::webkit-selection{ background-color: #E13300; color: white; }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body{
            margin: 0 15px 0 15px;
        }

        p.footer{
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        #container{
            margin: 10px;
            border: 1px solid #D0D0D0;
            -webkit-box-shadow: 0 0 8px #D0D0D0;
        }
    </style>
</head>
<body>

<div id="container">
    <h1>Install Live Support</h1>
    <?php
        if(file_exists('installer.lock')) {
            echo '<div id="body">Installer is currently locked. Delete installer.lock to be able to install</div><p class="footer">Page rendered in <strong>0.2041</strong> seconds</p>'; exit;
        }
    ?>
    <div id="body">
        <?php
            $step = $_GET['step'];
            if(isset($step)) {
                if($step=='1') {
                    // Setup default admin
                    echo 'Setup Default Administration Account.<br>';
                    ?>
                        <form action="?step=2" method="POST">Administrator Username: <input type='text' name='adm_user' value='admin'><br>Administrator Password:<input type='password' name='adm_pass' value='password'><br><input type='submit' name='submit' value='Continue'></form>
                    <?php
                } if($step=='2') {
                    // Populate database with information
                    echo 'Populating Database...<br>';
                    // Read SQL from SQL file.
                    $file = 'sql.sql';
                    if(!file_exists($file)) {
                        exit("SQL Missing");
                    } else {
                        $contents = file_get_contents($file);
                        $db->query($contents);
                    }
                    //$first = 'CREATE TABLE IF NOT EXISTS `add_chat` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(225) NOT NULL,`message` text NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;';
                    echo 'Populating Chat Tables<br>';
                    //$db->query($first);
                    //$second = "CREATE TABLE IF NOT EXISTS `admin` (`id` int(11) NOT NULL AUTO_INCREMENT,`username` varchar(25) NOT NULL,`password` varchar(50) NOT NULL,`owned_hid` int(11) NOT NULL COMMENT 'HID that person owns',PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;";
                    echo 'Populating Administration Tables<br>';
                    //$db->query($first);
                    $user = $_POST['adm_user'];
                    $pass = $_POST['adm_pass'];
                    $db->query("INSERT INTO `admin` (`id`, `username`, `password`, `owned_hid`) VALUES(1, '".$user."', '".$pass."', 1);");
                    //$db->query("CREATE TABLE IF NOT EXISTS `ranks` (`who` varchar(225) NOT NULL,`rank` varchar(225) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
                    $db->query("INSERT INTO `ranks` (`who`, `rank`) VALUES('".$user."', 'Admin');");

                    echo 'Populated Database<br>';
                    echo '<a href="?step=3"><button>Continue</button></a>';
                } if($step=='3') {
                    // Install Complete
                    echo 'Installation Completed.<br>';
                    $ourFileName = "installer.lock";
                    $ourFileHandle = fopen($ourFileName, 'w') or die("can't write locker file. please do manually: installer.lock");
                    fclose($ourFileHandle);
                }
            } else {
                ?>
                    <a href="?step=1"><button>Start Installation</button></a>
                <?php
            }
        ?>
    </div>

    <p class="footer">Page rendered in <strong>0.2041</strong> seconds</p>
</div>

</body>
</html>