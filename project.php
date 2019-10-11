<?php
$pageTitle = 'Project';
$bgColor='';
include 'init.php';
include $tpl.'navbar.php';
$profileID = $_GET['id'];
if(isset($_COOKIE['SPID'])){
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
         $stmt->execute(array(
             ":cookies_token"=>sha1($_COOKIE['SPID'])
         ));
         $rowlogin = $stmt->fetchAll();
         $idlogin = $rowlogin[0]['id'];
         $stmt2=$con->prepare("SELECT * FROM users WHERE id = :id");
         $stmt2->execute(array(':id'=>$profileID));
         $rows = $stmt2->fetchAll();
         ?> 
    <div class="container">
    <div class="img-cover">
        <img class="cover-image img-responsive" src="data\uploads\images\mb-bg-fb-08.png" alt="alt">
        
        <div class="user-nav hidden-sm hidden-xs">
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-info">
                        
                        <img class="profile-img" src="data\uploads\images\default.jpg" alt="profile Image">
                        <?php
                            if($idlogin == $profileID){
                                echo '<i class="fa fa-edit btn-change-pic"></i>';
                            }
                            ?>
                        <div class="infoprof">
                            <?php
                               $editname = $idlogin == $profileID? ' <i class="fa fa-edit btn-edit-name"></i>': '';

                            ?>
                            <h3><?php echo '<span>'. $rows[0]['Name'].'</span>'; echo $editname  ?></h3>
                            <p>Programming of php</p>
                        </div>    
                    </div>    
                </div>
                <div class="col-md-9">
                    <ul class="list-inline navbar-prof">
                        <li ><a href="">TimeLine</a></li>
                        <li><a href="gallary.php?id=<?php echo $_GET['id'] ?>">Album</a></li>
                        <li><a href="friend.php?id=<?php echo $_GET['id'] ?>">Friend</a></li>
                        <li class="btn btn-success"><a href="project.php?id=<?php echo $_GET['id'] ?>">Project</a></li>
                        <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend">
                    <?php 
                        $stmtFriend = $con->prepare('SELECT * FROM `friends` WHERE friend1=:f1 and friend2=:f2');
                        $stmtFriend->execute(array(':f1'=>$idlogin,':f2'=>$profileID));
                        $count = $stmtFriend->rowCount();
                        if($count>0){
                            ?>
                            <div class="addFriend">
                                <div class="btn btn-danger btnAddFriend" data-id="<?php echo $rows[0]['id']  ?>">Remove Friend</div>
                                <p style="display:inline;">1,299 people friend</p>
                            </div>

                            <?php
                        }else{
                            ?>
                               <div class="addFriend">
                                    <div class="btn btn-default btnAddFriend" data-id="<?php echo $rows[0]['id']  ?>"> + Add Friend</div>
                                    <p style="display:inline;">1,299 people friend</p>
                                </div>


                            <?php
                        }


                    ?>
                       
                    </div>
                    
                </div>    
            </div>
        </div><!--end div.user-nav-->
        
    </div><!--end the div.img-cover-->
    <div class="user-nav-mobile hidden-lg hidden-md">
                <div class="col-md-3">
                            <div class="profile-info-mobile">
                                <img class="profile-img-mobile" src="data\uploads\images\default.jpg" alt="profile Image">
                                <div class="infoprof">
                                    <h3><?php echo $rows[0]['Name']?></h3>
                                    <p>Programming of php</p>
                                </div>    
                            </div>    
                </div>
                <div class="col-md-9">
                    <ul class="list-inline navbar-prof-mobile">
                    <li class="btn btn-default"><a href="">TimeLine</a></li>
                    <li><a href="">Album</a></li>
                    <li><a href="">Friend</a></li>
                    <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend-mobile">
                        <ul>
                            <li><div class="btn btn-success btnAddFriend">+ Add Friend</div></li>
                            <li><p>1,299 people friend</p></li>
                        </ul>
                    </div>
                    
                </div> 
    </div><!--end div.user-nav-mobile-->
    </div>                    
    <div class="container">
        <div class="col-md-3">
        </div><!--end div.col-md-3-->
        <div class="col-md-9">
            <div class="control-folder">
                <div class="btn btn-primary btn-add-project"><i class="fa fa-plus"></i></div>
                <div class="upload-Project btn btn-success">Upload Project</div>
            </div><!--end div.control-folder-->
            <?php
                         $stmt3 = $con->prepare('SELECT project.* FROM project,user_project WHERE project.id = user_project.projectid AND user_project.userid =:userid');
                         $stmt3->bindParam(':userid',$idlogin,PDO::PARAM_INT);
                         $stmt3->execute();
                         $rows = $stmt3->fetchAll();
                         ?> 
                            <div class="container-projects">
                         <?php
                         
                         foreach($rows as $row){
                             ?>
                 
                 <div class="col-md-4 body-folder">
                     <a href="projectContent.php?pid=<?php echo $row['id'] ?>">
                        <div class="control-project">
                            <i class="fa fa-close"></i>
                        </div><!--end div.control-project-->
                        <div class="project">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            <h4><?php echo $row['Name']?></h4>
                        </div><!--end div.project-->
                    </a>
                     </div><!--end div.col-md-4-->
                 <?php
                         }
                 ?>
                
                </div><!--end div.container-projects-->
                
        </div><!--end div.col-md-9-->
    </div><!--end div.container-->
    <div class="overlay-upload-drag">
        <i class="fa fa-close close-drag"></i>
        <div class="dragzone" id="dropzone">
            Drop Zip files here to upload
        </div>
        <div class="progress">
            <div class="progress-bar progressDrag"  role="progressbar" aria-valuenow="70"
            aria-valuemin="0" aria-valuemax="100" style="width:70%">
                <span class="prcent"></span>
        </div>
</div>
    </div>
<?php
}//end $_COOKIE['SPID']
else{
    header('Location: login.php');
}

?>
    
    
    <script src="layout/js/jquery-1.12.1.min.js"></script> 
    <script src="layout/js/clipboard.min.js"></script> 
    <script src="<?php echo $js; ?>bootstrap.min.js"></script>
    <script src="<?php echo $js; ?>forall.js"></script>
    <script src="layout/js/endProject.js"></script>
</body>
</html>