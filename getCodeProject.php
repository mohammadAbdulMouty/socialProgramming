<?php
session_start();
include 'connect.php';
date_default_timezone_set('Asia/Damascus');
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
$stmtcheck = $con->prepare('SELECT * FROM `user_project` WHERE `projectid`=:projectid AND file_name=:filename');
$stmtcheck->bindParam(':projectid',$_POST['folderid']);
$stmtcheck->bindParam(':filename',$_POST['val']);
$stmtcheck->execute();
$rowcheck =$stmtcheck->fetchAll();
$stmtuse = 'no';
if($stmtcheck->rowCount()){
    $fileDate = $rowcheck[0]['data_open'];
    if(strtotime($fileDate) >= time()-5){
        $stmtuse = 'yes';
    }
}
if($stmtuse == 'no'){
$stmtBusy = $con->prepare('UPDATE `user_project` SET `file_name`=:file_name ,`data_open`=now() WHERE userid=:userid AND projectid =:projectid');
$stmtBusy->bindParam(':file_name',$_POST['val']);

$stmtBusy->bindParam(':userid',$idlogin);
$stmtBusy->bindParam(':projectid',$_POST['folderid']);
$stmtBusy->execute();

$path = getcwd().'\projects';
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_POST['folderid']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$dir = $path."\\".$rowsName[0]['Name']."\\".$_POST['val'];
$_SESSION['file_Path'] = $_POST['val'];
if(filesize($dir)>0){
$myfile = fopen($dir,'a+');
echo fread($myfile,filesize($dir));
fclose($myfile);
}
}
}