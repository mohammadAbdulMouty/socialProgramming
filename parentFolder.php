<?php
session_start();
include 'connect.php';
$path = getcwd().'\projects';
$dir = $path."\\".$_GET['parentFolder'];
$fileName = array();
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_SESSION['projectID']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$r = scandir($dir);
$checkon = $con->prepare('SELECT * FROM `user_project` WHERE projectid = :project');
$checkon->bindParam(':project',$_SESSION['projectID']);
$checkon->execute();
$rows = $checkon->fetchAll();
$fileName = array();
foreach($rows as $row){
    if(strtotime($row['data_open']) >= time()-5){

        array_push($fileName,$row['file_name']);
    }
}
for($i = 2 ;$i<count($r);$i++){
    $path_info = pathinfo($r[$i]);
    
    if(isset($path_info['extension'])){
        if(file_exists("layout/icons/".$path_info['extension'].".svg")){
            echo '<object data="layout/icons/'.$path_info['extension'].'.svg"></object>';
        }else{
            if($path_info['extension'] == 'js'){
                echo '<object data="layout/icons/javascript.svg"></object>';
            }else if($path_info['extension'] == 'jpg'||$path_info['extension'] == 'gif'||$path_info['extension'] == 'bmp'||$path_info['extension'] == 'png'){
                echo '<object data="layout/icons/image.svg"></object>';
            }else{
            echo '<object data="layout/icons/file.svg"></object>';
            }
        }
    }else{
        echo '<span class="glyphicon glyphicon-folder-open"></span>';
    }
        $folderParent = explode('\\',$_GET['parentFolder']);
        array_shift($folderParent);
        $folder = implode('\\',$folderParent);
        if($folder == ''){
            if(in_array(trim($r[$i]),$fileName)){
                echo "<div class='no-open-file'>".
                trim($r[$i])."";
                
            }else{
                echo "<div class='file-Name'>".
                trim($r[$i])."";
            }
        
        }else{
            if(in_array(trim($folder,'\\').'\\'.trim($r[$i])."",$fileName)){
            echo "<div class='file-check no-open-file'>".
            trim($folder,'\\').'\\'.trim($r[$i])."";
            }else{
                echo "<div class='file-check file-Name'>".
                trim($folder,'\\').'\\'.trim($r[$i])."";
            }
        }
   
   
   
    
    echo "</div>";
    
 
}