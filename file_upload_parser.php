<?php
include 'init.php'; // The file name
$fileTmpLoc = $_FILES["resim"]["tmp_name"]; // File in the PHP tmp folder
$fileName =  $_FILES["resim"]["name"];
$fileSize =  $_FILES["resim"]["size"];
// $fileType = $_FILES["file1"]["type"]; // The type of file it is
// $fileSize = $_FILES["file1"]["size"]; // File size in bytes
// $fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
var_dump($_FILES);
$fileNameUplode = $_GET['name'];
move_uploaded_file($fileTmpLoc, "data/uploads/files/".$fileNameUplode);


?>
