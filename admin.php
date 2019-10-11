<?php
$pageTitle = 'admin';
$bgColor='';
include 'init.php';
if(isset($_COOKIE['SPIDadmin'])){
$stmtCNewGroup = $con->prepare('SELECT * FROM `group` WHERE `status` =0');
$stmtCNewGroup->execute();
$stmtCountGroup = $stmtCNewGroup->rowCount();

?>
<div class="simple-nav">
<div class="admin-logout">
    <div class="btn btn-danger btn-block center-block adminlogoutbtn">Log out</div>
</div><!--end div.admin-logout-->
</div><!--end div.simple-nav-->
<div class="admin-content">
    <div class="container-fluid">
            <a href="adminContent.php?status=1">
                <div class="col-md-5 admin-div new-group-admin">
                <i class="fa fa-users icon-admin"></i>
                <p class="Name-group-content">New Group</p>
                <span class="count-admin-content count-group"><?=$stmtCountGroup?></span>
                </div>
            </a>
            <a href="adminContent.php">
                <div class="col-md-5 admin-div report-user">
                    <i class="fa fa-address-book icon-admin"></i>
                    <p class="Name-group-content">User Report</p>
                    <span class="count-admin-content count-group"><?=$stmtCountGroup?></span>
                </div>
            </a>
            <a href="adminContent.php">
                <div class="col-md-5 admin-div new-group-chat">
                    <i class="fa fa-user-plus icon-admin"></i>
                    <p class="Name-group-content">New User</p>
                    <span class="count-admin-content count-group"><?=$stmtCountGroup?></span>
                </div>
            </a>
            <a href="adminContent.php">
                <div class="col-md-5 admin-div report-group">
                    <i class="fa fa-address-card icon-admin"></i>
                    <p class="Name-group-content">Group Report</p>
                    <span class="count-admin-content count-group"><?=$stmtCountGroup?></span>
                </div>
            </a>
        
    </div><!--end div.container-->
<div><!--end div.admin-content-->
<script src="layout/js/jquery-1.12.1.min.js"></script> 
<script src="layout/js/clipboard.min.js"></script> 
<script src="<?php echo $js; ?>bootstrap.min.js"></script>
<script src="<?php echo $js; ?>admin.js"></script>
<?php
}else{
    header('Location: login.php');
}
?>