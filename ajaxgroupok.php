<?php
include 'connect.php';
$idGroup = $_GET['idg'];
if($_GET['status']==1){
$stmt = $con->prepare('UPDATE `group` SET `status` = 1 WHERE id =:idgroup');
$stmt->bindParam(':idgroup',$idGroup,PDO::PARAM_INT);
$stmt->execute();
}else{
    $stmt = $con->prepare('DELETE FROM `group` WHERE id=:idgroup');
$stmt->bindParam(':idgroup',$idGroup,PDO::PARAM_INT);
$stmt->execute();
}
$stmt = $con->prepare('SELECT * FROM `group` WHERE `status` =0');
$stmt->execute();
$rows = $stmt->fetchAll();

?>

<div class="element-new-group">
                       <table class="table-admin-content">
                        <tr>
                            <th>Group Name</th>
                            <th>Description</th>
                            <th>user Name</th>
                            <th>ok</th>
                            <th>cancel</th>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                $stmtuser=$con->prepare('SELECT users.* FROM `user_group` ,users WHERE user_group.user_id = users.id AND Group_id = :groupid');
                                $stmtuser->bindParam(':groupid',$row['id'],PDO::PARAM_INT);
                                $stmtuser->execute();
                                $username = $stmtuser->fetchAll();
                            
                        ?>
                        <tr>
                            <td><?= $row['Group_name']?></td>
                            <td><?= $row['Description']?></td>
                            <td><?= isset($username[0]['Name'])?$username[0]['Name']:'None' ?></td>
                            <td><span class="btn btn-primary btn-admin-okg" data-gid="<?= $row['id']?>">ok</span></td>
                            <td><span class="btn btn-danger btn-admin-deleteg" data-gid="<?= $row['id']?>">delete</span></td>
                        </tr>
                            <?php }?>
                       </table>
                    </div><!--end div.element-new-group-->
                
        


