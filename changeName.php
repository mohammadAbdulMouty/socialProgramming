<?php
include 'connect.php';
$stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
$stmt->execute(array(
    ":cookies_token"=>sha1($_COOKIE['SPID'])
));
$rowlogin = $stmt->fetchAll();
$idlogin = $rowlogin[0]['id'];

$stmtChangeName = $con->prepare('UPDATE users SET Name = :name WHERE id = :id');
$stmtChangeName->bindParam(':name',$_POST['Name'],PDO::PARAM_INT);
$stmtChangeName->bindParam(':id',$idlogin,PDO::PARAM_INT);
$stmtChangeName->execute();
$stmt2=$con->prepare("SELECT * FROM users WHERE id = :id");
$stmt2->execute(array(':id'=>$idlogin));
$rows = $stmt2->fetchAll();
echo $rows[0]['Name'];