<?php
include 'init.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare('DELETE FROM `cookies_token` WHERE token=:token');
    $stmt->execute(array(':token'=>sha1($_COOKIE['SPID'])));
    setcookie('SPID' , '1' , time()-3600,'/');
    setcookie('SPID_' , '1' , time()-3600,'/');
    header('Location: login.php');
}