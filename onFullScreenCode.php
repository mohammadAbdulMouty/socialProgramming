<?php
include 'connect.php';
$idpostCode =(int)$_GET['postcode'];
$stmtDisplayChild = $con->prepare('SELECT * FROM `code_post_solution` WHERE post_code_id = :postCode');
$stmtDisplayChild->bindParam(':postCode',$idpostCode,PDO::PARAM_INT);
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
?>