<?php 
session_start();
include 'connect.php';
$path = getcwd().'\projects';
$stmtName = $con->prepare('SELECT Name FROM `project` WHERE id=:id');
$stmtName->bindParam(':id',$_POST['folderid']);
$stmtName->execute();
$rowsName = $stmtName->fetchAll();
$dir = $path."\\".$rowsName[0]['Name'].'\\'.$_POST['val'];
$checkon = $con->prepare('SELECT * FROM `user_project` WHERE projectid = :project');
$checkon->bindParam(':project',$_POST['folderid']);
$checkon->execute();
$rows = $checkon->fetchAll();
$fileName = array();
foreach($rows as $row){
    if(strtotime($row['data_open']) >= time()-5){

        array_push($fileName,$row['file_name']);
    }
}
$r = scandir($dir);
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
    if(in_array($_POST['val'].'\\'.trim($r[$i])."",$fileName)){
        echo "<div class='file-check no-open-file'>".
        $_POST['val'].'\\'.trim($r[$i])."";
       
        
        echo "</div>";
    }else{
        echo "<div class='file-check file-Name'>".
        $_POST['val'].'\\'.trim($r[$i])."";
       
        
        echo "</div>";
    }
 
}