<?php
include 'init.php';
if(isset($_POST['user_name'])){
    $usernameShk =false;
    if(!empty($_POST['user_name'])){
    $sel=$con->prepare('SELECT * FROM users WHERE Name = :zname');
    $sel->execute(array('zname'=>$_POST['user_name']));
    if($sel->rowCount()){
        echo '<a href="#" data-toggle="tooltip" data-placement="left" title="Hooray!"><i class="fa fa-close" style="color: red;"></i></a>';
        $usernameShk =false;
    }else{
        echo '<i class="fa fa-check"style="color: blue;"></i>';
        $usernameShk=true;
    }
}
}