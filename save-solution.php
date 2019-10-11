<?php
include 'connect.php';

$stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
$stmt->execute(array(
    ":cookies_token"=>sha1($_COOKIE['SPID'])
));
$rowlogin = $stmt->fetchAll();
$idlogin = $rowlogin[0]['id'];
if($_GET['status']==1){
$code =  $_POST['form'];
$parent =  $_POST['parent'];
$stmtChild=$con->prepare('INSERT INTO `code_post_solution`(`code`, `date`, `post_code_id`, `user_id`) VALUES (:code,now(),:postid,:idlogin)');
$stmtChild->bindParam(':code',$code,PDO::PARAM_STR);
$stmtChild->bindParam(':postid',$parent,PDO::PARAM_INT);
$stmtChild->bindParam(':idlogin',$idlogin,PDO::PARAM_INT);
$stmtChild->execute();
$stmtDisplayChild = $con->prepare('SELECT * FROM `code_post_solution` WHERE post_code_id = :postCode');
$stmtDisplayChild->bindParam(':postCode',$parent,PDO::PARAM_INT);
$stmtDisplayChild->execute();
$rowdDisp = $stmtDisplayChild->fetchAll();
echo '<li class="list-prog" data-child="orginal"><span>orginal</span></li>';
foreach($rowdDisp as $row){
    $userSolution = $con->prepare('SELECT * FROM users WHERE id=:id');
    $userSolution->bindParam(':id',$row['user_id'],PDO::PARAM_INT);
    $userSolution->execute();
    $rowsUser = $userSolution->fetchAll();
?>
<li class="list-prog" data-child="<?php echo $row['id']?>"><span><?php echo $rowsUser[0]['Name'] ?> </span></li>
      

<?php

}
}
else if($_GET['status'] == 2){
$idPOSTCodeSolution = $_POST['data'];
$idparent = $_POST['parent'];
if($idPOSTCodeSolution == 'orginal'){
    $stmtParnet = $con->prepare('SELECT `code` FROM `code_post` WHERE id = :idparent');
    $stmtParnet->bindParam(':idparent',$idparent,PDO::PARAM_INT);
    $stmtParnet->execute();
    $rowParent = $stmtParnet->fetchAll();
    echo $rowParent[0]['code'];
}
else{
$POSTCodeSolutionStmt = $con->prepare('SELECT code FROM code_post_solution WHERE id=:solid');
$POSTCodeSolutionStmt->bindParam(':solid',$idPOSTCodeSolution,PDO::PARAM_INT);
$POSTCodeSolutionStmt->execute();
$rowspostStmt = $POSTCodeSolutionStmt->fetchAll();
echo $rowspostStmt[0]['code'];
}


}
?>

