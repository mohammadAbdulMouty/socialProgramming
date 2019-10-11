<?php
$bgColor='';
include 'init.php';
if(isset($_GET['status'])){
if($_GET['status']==1){
    ?>
    <div class="simple-nav">
    <div class="admin-logout">
        <div class="btn btn-danger btn-block center-block">Log out</div>
    </div><!--end div.admin-logout-->
    </div><!--end div.simple-nav-->
    <?php
    $stmt = $con->prepare('SELECT * FROM `group` WHERE `status` =0');
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    ?>
    <div class="container-admin-content">
        <div class="container container-new-group-admin">
            
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
                
        
        </div><!--end div.container-->
    </div><!--end div.container-adimn-content-->
    <script src="layout/js/jquery-1.12.1.min.js"></script> 
<script src="layout/js/clipboard.min.js"></script> 
<script src="<?php echo $js; ?>bootstrap.min.js"></script>
<script src="<?php echo $js; ?>admin.js"></script>
<?php
}



}