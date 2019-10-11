<?php
    $postonload ="mm";
    $pageTitle = 'Profile';
    include 'init.php';
    include $tpl.'navbar.php';
    $profileID = $_GET['id'];
    if(isset($_COOKIE['SPID'])){
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
         $stmt->execute(array(
             ":cookies_token"=>sha1($_COOKIE['SPID'])
         ));
         $rowlogin = $stmt->fetchAll();
         $idlogin = $rowlogin[0]['id'];
         $stmt2=$con->prepare("SELECT * FROM users WHERE id = :id");
         $stmt2->execute(array(':id'=>$profileID));
         $rows = $stmt2->fetchAll();
         
?>


<div class="hi"></div>






<?php


        }
        ?>
        <script src="layout/js/jquery-1.12.1.min.js"></script> 
        <script src="layout/js/end.js"></script> 
