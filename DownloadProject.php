<?php
session_start();
 include 'init.php';
 $path = getcwd().'\projects';
 
 $stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
 $stmtName->bindParam(':id',$_SESSION['projectID']);
 $stmtName->execute();
 $rowsName = $stmtName->fetchAll();
 $zip = new ZipArchive();
 $dir = $path."\\".$rowsName[0]['Name'];
 $zip_name = $rowsName[0]['Name'].'.zip';
 $res = $zip->open($dir.'\\'.$zip_name, ZipArchive::CREATE);
 if ($res === TRUE) {
     echo $dir.'\\'.$zip_name;
 }
 chmod($dir,777);
 $dp = opendir($dir);

 $r = scandir($dir);
 zipFile($dir,$path.'\\'.$zip_name);
 $archive_file_name = realpath($dir.'\\'.$zip_name);
 header("Content-type: application/zip"); 
 header("Content-Disposition: attachment; filename=projects/".$zip_name."");
 header("Content-Length: ".filesize("projects/".$zip_name));
 header("Pragma: no-cache"); 
 header("Expires: 0");
 ob_clean();
 flush();
 readfile("projects/".$zip_name);






 ?>