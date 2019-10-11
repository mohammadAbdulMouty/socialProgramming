<?php
session_start();
include 'connect.php';
$path = getcwd().'\projects';
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_POST['data']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$dir = $path."\\".$rowsName[0]['Name']."\\".$_SESSION['file_Path'];
$op = fopen($dir,'w');
fwrite($op,$_POST['val']);