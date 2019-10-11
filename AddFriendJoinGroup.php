<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     if($_GET['status'] == 1){
     $stmt2 = $con->prepare('INSERT INTO `friends`(`friend1`, `friend2`, `date`) VALUES (:friend2,:friend1,now()),(:friend1,:friend2,now())');
     $stmt2->bindParam(':friend2',$idlogin,PDO::PARAM_INT);
     $stmt2->bindParam(':friend1',$_GET['id'],PDO::PARAM_INT);
     $stmt2->execute();
     }else if($_GET['status']==2){
         $stmtdel= $con->prepare('DELETE FROM `friends` WHERE `friend1` =:f1 AND `friend2` = :f2 OR `friend2` =:f1 AND `friend1` =:f2 ');
         $stmtdel->bindParam(':f1',$idlogin,PDO::PARAM_INT);
         $stmtdel->bindParam(':f2',$_GET['id'],PDO::PARAM_INT);
         $stmtdel->execute();
     }



}