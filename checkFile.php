<?php
session_start(); 
date_default_timezone_set('Asia/Damascus');
// var_dump($_SESSION['projectID']);
// var_dump($_SESSION['file_Path']);
// var_dump($_SESSION['file']);
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
$path = getcwd().'\projects';
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_SESSION['projectID']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$fileName = array();
$dir = $path."\\".$_GET['c'];
$checkon = $con->prepare('SELECT * FROM `user_project` WHERE projectid = :project AND userid !=:userid');
$checkon->bindParam(':project',$_SESSION['projectID']);
$checkon->bindParam(':userid',$idlogin);
$checkon->execute();
$rows = $checkon->fetchAll();
foreach($rows as $row){
    if(strtotime($row['data_open']) >= time()-5){

        array_push($fileName,$row['file_name']);
    }
}
if(!empty($fileName)){
echo json_encode($fileName);
}
}

