<?php
include 'connect.php';
$stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
$stmt->execute(array(
    ":cookies_token"=>sha1($_COOKIE['SPID'])
));
$rowlogin = $stmt->fetchAll();
$idlogin = $rowlogin[0]['id'];
$color = array("#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d");
if($_GET['status']==1){
    $code =  $_POST['code'];
    $parent =  $_POST['pid'];
    $stmtChild=$con->prepare('INSERT INTO `code_post_solution`(`code`, `date`, `post_code_id`, `user_id`) VALUES (:code,now(),:postid,:idlogin)');
    $stmtChild->bindParam(':code',$code,PDO::PARAM_STR);
    $stmtChild->bindParam(':postid',$parent,PDO::PARAM_INT);
    $stmtChild->bindParam(':idlogin',$idlogin,PDO::PARAM_INT);
    $stmtChild->execute();
    $stmtDisplayChild = $con->prepare('SELECT * FROM `code_post_solution` WHERE post_code_id = :postCode');
    $stmtDisplayChild->bindParam(':postCode',$parent,PDO::PARAM_INT);
    $stmtDisplayChild->execute();
    $rowdDisp = $stmtDisplayChild->fetchAll();
    ?>
    
    <div class="orginal active" data-id="orginal" data-cid="<?php echo $parent?>">
    <p><?php echo 'Main' ?></p>
    <span style="background: #70befc;"></span>
</div>
    <?php
    foreach($rowdDisp as $row){
        $userSolution = $con->prepare('SELECT * FROM users WHERE id=:id');
        $userSolution->bindParam(':id',$row['user_id'],PDO::PARAM_INT);
        $userSolution->execute();
        $rowsUser = $userSolution->fetchAll();
        ?>
<div class="orginal" data-id="<?php echo $row['id']?>">
        <p><?php echo $rowsUser[0]['Name'] ?></p>
        <span style="background:<?php echo $color[array_rand($color)] ?>"></span>
        </div>

<?php
    }
    
}
if($_GET['status'] == 2){
    $idPostSolution =$_POST['child'];
    $codePostid=$_POST['codePostid1'];
    if($idPostSolution=='orginal'){
        $stmt2 = $con->prepare('SELECT code FROM `code_post` WHERE id=:id');
        $stmt2->bindParam(':id',$codePostid,PDO::PARAM_INT);
        $stmt2->execute();
        $row2 = $stmt2->fetchAll();
        echo $row2[0]['code'];

    }else{

    
    $stmt =$con->prepare('SELECT code FROM `code_post_solution` WHERE id=:id');
    $stmt->bindParam(':id',$idPostSolution,PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetchAll();
    echo $row[0]['code'];
    }

}