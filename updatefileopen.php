<?php
include 'connect.php';
session_start();
if(isset($_COOKIE['SPID'])){
    //projectID
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     $stmtBusy = $con->prepare('UPDATE `user_project` SET `file_name`=:file_name ,`data_open`=now() WHERE userid=:userid AND projectid =:projectid');
$stmtBusy->bindParam(':file_name',$_GET['file']);

$stmtBusy->bindParam(':userid',$idlogin);
$stmtBusy->bindParam(':projectid',$_SESSION['projectID']);
$stmtBusy->execute();



    }