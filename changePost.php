<?php
include 'connect.php';
$stmt = $con->prepare('UPDATE `posts` set body =:body WHERE id=:id');
$stmt->bindParam(':body',$_POST['val'],PDO::PARAM_STR);
$stmt->bindParam(':id',$_POST['id'],PDO::PARAM_INT);
$stmt->execute();
$stmt2 = $con->prepare('SELECT body From posts WHERE id=:id');
$stmt2->bindParam(':id',$_POST['id'],PDO::PARAM_INT);
$stmt2->execute();
$rows = $stmt2->fetchAll();
echo $rows[0]['body'];
