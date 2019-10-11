<?php 
include 'connect.php';
$error = array();
if(isset($_COOKIE['SPID'])){
    
    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];

if(!isset($_FILES['img']['name'])) {
    $error[] = 'Please Chosse The image';
}
if(!isset($_POST['name']) || $_POST['name'] == ''){
    $error[] = 'Please Input Name of Group';
}
if(!isset($_POST['des']) || $_POST['des'] == ''){
    $error[] = 'Please input description of Group';
}
if(empty($error)){
    $rand = rand(0,9999999);
    $fileTmpLoc = $_FILES["img"]["tmp_name"]; // File in the PHP tmp folder
    $fileName =  $_FILES["img"]["name"];
    $fileSize =  $_FILES["img"]["size"];
    $fileName = $rand.'_'.$fileName;
    move_uploaded_file($fileTmpLoc,'data\uploads\group-files\\'.$fileName);
    $stmt = $con->prepare('INSERT INTO `group`(`Group_name`, `Group_members`, `Description`, `image` ) VALUES (:groupname,0,:descr,:imgname)');
    $stmt->bindParam(':groupname',$_POST['name'],PDO::PARAM_STR);
    $stmt->bindParam(':descr',$_POST['des'],PDO::PARAM_STR);
    $stmt->bindParam(':imgname',$fileName,PDO::PARAM_STR);
    $stmt->execute();
    $stmtselect = $con->prepare('SELECT id from `group` WHERE `Group_name` = :groupname And `Description` = :desd');
    $stmtselect->bindParam(':groupname',$_POST['name']);
    $stmtselect->bindParam(':desd',$_POST['des']);
    $stmtselect->execute();
    $rows =$stmtselect->fetchAll();

   $stmt2 = $con->prepare('INSERT INTO `user_group`(`permission`, `user_id`, `Group_id`) VALUES (1,:idlogin,:grouid)');
   $stmt2->bindParam(':idlogin',$idlogin,PDO::PARAM_INT);
   $stmt2->bindParam(':grouid',$rows[0]['id'],PDO::PARAM_INT);
   $stmt2->execute();
}else{
    foreach($error as $er){
        ?>
    <div class="error-ng-dis">
        <?php 
            echo $er;
        ?>
    </div>

<?php
    }

}
}
