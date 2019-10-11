<?php 
session_start();
include 'connect.php';
include 'includes/functions/function.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
$fileName = $_SESSION['file'];
$projectID = $_SESSION['projectID'];
$grostmt = $con->prepare('SELECT * FROM `project` WHERE id =:gid');
$grostmt->bindParam(':gid',$projectID,PDO::PARAM_INT);
$grostmt->execute();
$rows = $grostmt->fetchAll();
$projectName = $rows[0]['Name'];
$filePath = 'projects\\'.$projectName.'\\'.$fileName;
$array = strrpos($filePath,'\\');

$dir =  substr($filePath,0,$array);

$stmtCheck = $con->prepare('SELECT * FROM `user_project` WHERE projectid =:projectid AND userid =:userid');
$stmtCheck->bindParam(':projectid',$projectID,PDO::PARAM_INT);
$stmtCheck->bindParam(':userid',$idlogin,PDO::PARAM_INT);
$stmtCheck->execute();
$count = $stmtCheck->rowCount();
if($_GET['status']==1){
if($count>0){
    if(is_file($filePath)){
        unlink($filePath);
    }else if(is_dir($filePath)){
        rrmdir($filePath);
    }
}
}else if($_GET['status']==2){
    if($count >0){
        $new = $_GET['new'];
        rename($filePath,$dir.'\\'.$new);
    }
}


// $r = scandir($dir);
// for($i = 2 ;$i<count($r);$i++){
//     $path_info = pathinfo($r[$i]);
    
//     if(isset($path_info['extension'])){
//         if(file_exists("layout/icons/".$path_info['extension'].".svg")){
//             echo '<object data="layout/icons/'.$path_info['extension'].'.svg"></object>';
//         }else{
//             if($path_info['extension'] == 'js'){
//                 echo '<object data="layout/icons/javascript.svg"></object>';
//             }else if($path_info['extension'] == 'jpg'||$path_info['extension'] == 'gif'||$path_info['extension'] == 'bmp'||$path_info['extension'] == 'png'){
//                 echo '<object data="layout/icons/image.svg"></object>';
//             }else{
//             echo '<object data="layout/icons/file.svg"></object>';
//             }
//         }
//     }else{
//         echo '<span class="glyphicon glyphicon-folder-open"></span>';
//     }
    
//     echo "<div class='file-Name'>".
//     $dir.'\\'.trim($r[$i])."";
   
    
//     echo "</div>";
    
 
// }

    }
