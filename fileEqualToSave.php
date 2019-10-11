<?php
session_start();
include 'connect.php';
$path = getcwd().'\projects';
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_POST['idfile']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$dir = $path."/".$rowsName[0]['Name']."/".$_SESSION['file_Path'];

$fileOpen = fopen($dir,'r');
$fread = fread($fileOpen,filesize ($dir));
if(file_get_contents($dir)== $_POST['newVal']){
    echo 'no save';
}else{
    
    echo 'save';
}
