<?php
include 'connect.php';
$stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
$stmt->execute(array(
    ":cookies_token"=>sha1($_COOKIE['SPID'])
));
$rowlogin = $stmt->fetchAll();
$idlogin = $rowlogin[0]['id'];

$stmt = $con->prepare('SELECT * FROM `friends` WHERE friend1=:f1 and friend2=:f2');
$stmt->execute(array(':f1'=>$idlogin,':f2'=>$_GET['idProfile']));
$count = $stmt->rowCount();
if($count >0){
    $stmt2 =$con->prepare('DELETE FROM `friends` WHERE (`friend1`=:idlogin AND `friend2` =:idprofiel) OR (`friend1`=:idprofiel AND `friend2`=:idlogin)');
    $stmt2->execute(array(':idlogin'=>$idlogin,':idprofiel'=>$_GET['idProfile']));
    echo ' <div class="addFriend">
        <div class="btn btn-default btnAddFriend" data-id="' .$_GET['idProfile'].'"> + Add Friend</div>
        <p style="display:inline;">1,299 people friend</p>
</div>';
}else{
    $stmt3 = $con->prepare('INSERT INTO `friends` (`friend1`, `friend2`, `date`) VALUES (:userlogin, :userprofile, now()), (:userprofile, :userlogin, now())');
    $stmt3->execute(array(':userlogin'=>$idlogin,':userprofile'=>$_GET['idProfile']));
    echo ' <div class="addFriend">
    <div class="btn btn-danger btnAddFriend" data-id="'.$_GET['idProfile'].'">Remove Friend</div>
    <p style="display:inline;">1,299 people friend</p>
</div>';
}


