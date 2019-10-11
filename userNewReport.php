<?php
include 'connect.php';
//idprofile
//mess
//var_dump($_GET);
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     $stmt2=$con->prepare('INSERT INTO `user_report`(`user_send_re`, `user_report`, `contentreport`) VALUES (:user_send,:user_report,:contentreport)');
     $stmt2->bindParam(':user_send',$idlogin,PDO::PARAM_INT);
     $stmt2->bindParam(':user_report',$_GET['idprofile'],PDO::PARAM_INT);
     $stmt2->bindParam(':contentreport',$_GET['mess'],PDO::PARAM_STR);
     $stmt2->execute();




    }