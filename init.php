<?php
// set and get session attributes
include 'connect.php';


    
    //Routes
  

    $tpl = 'includes/templates/';//templete Directory
    $css = 'layout/css/';//css Directory
    $js = 'layout/js/';//js Directory
    $func = 'includes/functions/';//function Directory
    $lang = 'includes/languages/';//function languages
    $lib ='includes/libraries/';

    include $func."function.php";
	include $lang.'english.php';
	include $tpl."header.php";
    require $lib.'PHPMailer/src/Exception.php';
    require $lib.'PHPMailer/src/PHPMailer.php';
    require $lib.'PHPMailer/src/SMTP.php';
    
    ?>
    