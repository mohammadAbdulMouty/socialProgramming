<?php
include 'connect.php';
include 'includes/functions/function.php';
if(isset($_COOKIE['SPID'])){
    
    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    if($_GET['status'] == 1){
    $stmt = $con->prepare('DELETE FROM `user_group` WHERE GROUP_id =:groupid AND user_id=:userid');
    $stmt->bindParam(':groupid',$_GET['gid'],PDO::PARAM_INT);
    $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt->execute();
}else if($_GET['status']== 2){
    $stmt = $con->prepare('INSERT INTO `user_group`(`permission`, `user_id`, `Group_id`) VALUES (0,:idlogin,:groupid)');
    $stmt->bindParam(':groupid',$_GET['gid'],PDO::PARAM_INT);
    $stmt->bindParam(':idlogin',$idlogin,PDO::PARAM_INT);
    $stmt->execute();
}


}
    ?>