<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
        echo 'hi';
        $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmtcookies->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        $rowlogin =$stmtcookies->fetchAll();
        $idlogin = $rowlogin[0]['id'];
if($_GET['statuss']==1){
    $groupid = $_GET['gid'];
    $stmt = $con->prepare('INSERT INTO `user_group`( `permission`, `user_id`, `Group_id`) VALUES (0,:userid,:groupid)');
    $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt->bindParam(':groupid',$groupid,PDO::PARAM_INT);
    $stmt->execute();

}
if($_GET['statuss']==2){
    echo 'mohammad abdul';
    $groupid = $_GET['gid'];
    $stmt2 = $con->prepare('DELETE FROM `user_group` WHERE user_id = :userid AND Group_id = :groupid');
    
    $stmt2->execute(array(':userid'=>$idlogin,':groupid'=>$groupid));
}



}