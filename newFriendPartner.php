<?php
session_start();
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmt->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin = $stmt->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    $projectId = $_SESSION['projectID'];
    $stmtggg = $con->prepare('SELECT * from user_project WHERE `userid`=:userid AND projectid =:projectid AND status = 1');
    $stmtggg->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmtggg->bindParam(':projectid',$projectId,PDO::PARAM_INT);
    $stmtggg->execute();
    $count = $stmtggg->rowCount();

    if($count >0){
        
    if(isset($_GET['status'])){
    if($_GET['status'] == 1){
        $stmtinst = $con->prepare('INSERT INTO `user_project`(`userid`, `projectid`, `status`) VALUES (:userid,:projectid,:statuss)');
        $stmtinst->bindParam(':userid',$_GET['id'],PDO::PARAM_INT);
        $stmtinst->bindParam(':projectid',$projectId,PDO::PARAM_INT);
        $stmtinst->bindValue(':statuss',0,PDO::PARAM_INT);
        $stmtinst->execute();
    }
    else if($_GET['status'] == 2){
        $stmtinst = $con->prepare('DELETE FROM `user_project` WHERE userid =:userid AND projectid =:projectid AND status !=1');
        $stmtinst->bindParam(':userid',$_GET['id'],PDO::PARAM_INT);
        $stmtinst->bindParam(':projectid',$projectId,PDO::PARAM_INT);
        $stmtinst->execute();
    }
}










      
         $stmt2 = $con->prepare('SELECT users.* FROM friends,users WHERE users.id = friends.friend2 AND friends.friend1 =:f1');
         $stmt2->bindParam(':f1',$idlogin,PDO::PARAM_INT);
         $stmt2->execute();
         $rows = $stmt2->fetchAll();
    
         foreach($rows as $row){
             $stmt44 = $con->prepare('SELECT * FROM user_project WHERE userid = :userid AND projectid= :projectid');
             $stmt44->bindParam(':userid',$row['id'],PDO::PARAM_INT);
             $stmt44->bindParam(':projectid',$projectId,PDO::PARAM_INT);
             $stmt44->execute();
             $count = $stmt44->rowCount();
            
             ?>

                        <div class="friend-partner">
                            <h3><?= $row['Name'] ?></h3>
                            <?php
                            if($count>0){
                                ?>
                                    <span class="remove-friend-partners" data-id="<?= $row['id']?>">Added</span>
                                <?php
                            }else{
                                ?>
                                    <span class="add-friend-partners" data-id="<?= $row['id']?>">Add</span>
                                <?php
                            }
                            
                            ?>
                        </div><!--end div.friend-partner-->

                <?php
         }

        }
        }