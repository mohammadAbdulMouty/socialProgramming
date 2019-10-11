<?php 
header('Content-Type: application/json');
$uploaded = array();
if(!empty($_FILES['file']['name'][0])){
    foreach($_FILES['file']['name'] as $postion=>$name){
        if(move_uploaded_file($_FILES['file']['tmp_name'][$postion],'uploadsss/'.$name)){
            
        }
    }
}