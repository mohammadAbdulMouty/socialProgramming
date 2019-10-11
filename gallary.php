
<?php
    $postonload ="mm";
    $pageTitle = 'Profile';
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
                        <div class="infoprof">
                            <h3><?php echo $rows[0]['Name']?></h3>
                            <p>Programming of php</p>
                        </div>    
                    </div>    
                </div>
                <div class="col-md-9">
                    <ul class="list-inline navbar-prof">
                        <li ><a href="index.php?id=<?php echo $_GET['id'] ?>">TimeLine</a></li>
                        <li class="btn btn-success"><a href="gallary.php?id=<?php echo $_GET['id'] ?>">Album</a></li>
                        <li><a href="">Friend</a></li>
                        <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend">
                    <?php 
                        $stmtFriend = $con->prepare('SELECT * FROM `friends` WHERE friend1=:f1 and friend2=:f2');
                        $stmtFriend->execute(array(':f1'=>$idlogin,':f2'=>$profileID));
                        $count = $stmtFriend->rowCount();
                        if($count>0){
                            ?>
                            <ul class="list-inline">
                                <li><div class="btn btn-danger btnAddFriend" data-id="<?php echo $rows[0]['id']?>">remove Friend</div></li>
                                <li><p>1,299 people friend</p></li>
                            </ul>

                            <?php
                        }else{
                            ?>
                                 <ul class="list-inline">
                                <li><div class="btn btn-success btnAddFriend" data-id="<?php echo $rows[0]['id']?>">+ Add Friend</div></li>
                                <li><p>1,299 people friend</p></li>
                            </ul>


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
    <div class="col-md-3"></div>
    <div class="col-md-9">
           <ul class="album-photos">
               <?php
                    $stmtimg = $con->prepare('SELECT post_image.*,posts.* FROM post_image INNER JOIN posts on posts.id = post_image.post_id WHERE user_id =:userid');
                    $stmtimg->execute(array(':userid'=>$_GET['id']));
                   $rowsImg = $stmtimg->fetchAll();            
                   foreach($rowsImg as $rowimg){     
                    ?>
                   <li><img src="data\uploads\images\<?php echo $rowimg['image_name'] ?>"></li>     
                   
                   <?php
                   }
                   ?>
                </ul>
           
    </div>
    <div class="img-overlay">
            <i class="fa fa-close close-overlay"></i>            
            <img src="" alt="">
        
    </div>
    <script src="layout/js/jquery-1.12.1.min.js"></script>
    <script src="layout/js/gallary.js"></script>
    <script></script>
    </body>
    </html>


    <?php

                    }else{
                        header('Location: login.php');
                    }
?>