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
                        <li><a href="gallary.php?id=<?php echo $_GET['id'] ?>">Album</a></li>
                        <li class="btn btn-success"><a href="friend.php?id=<?php echo $_GET['id'] ?>">Friend</a></li>
                        <li><a href="">About</a></li>
                    </ul>
                    <div class="add-friend">
                    <?php 
                        $stmtFriend = $con->prepare('SELECT * FROM `friends` WHERE friend1=:f1 and friend2=:f2');
                        $stmtFriend->execute(array(':f1'=>$idlogin,':f2'=>$profileID));
                        $count = $stmtFriend->rowCount();
                        if($profileID !== $idlogin){
                        if($count>0){
                            
                            ?>
                            
                           <div class="addFriend">
                                <div class="btn btn-danger btnAddFriend" data-id="<?php echo $profileID ?>">Remove Friend</div>
                                <p style="display:inline;">1,299 people friend</p>
                            </div>
                            <?php
                        }else{
                            ?>
                           
                            <div class="addFriend">
                                <div class="btn btn-default btnAddFriend" data-id="<?php echo $profileID ?>"> + Add Friend</div>
                                <p style="display:inline;">1,299 people friend</p>
                           </div>

                            <?php
                        }
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
    <div class="col-md-3">
        
    </div><!--end div.col-md-3-->
    <?php
        $stmtfriend = $con->prepare('SELECT users.* from users,friends WHERE friends.friend2 = users.id AND friends.friend1 = 1');
        $stmtfriend->execute();
        $rowsFriend = $stmtfriend->fetchAll();
    ?>
    <div class="col-md-9">
        <?php
            foreach($rowsFriend as $row){
                
        ?>
         <div class="col-md-6 friend-list">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        <img src="data\uploads\images\<?php echo $row['image'] ?>" alt="" class="img-circle">
                    </div><!--end div.pull-left-->
                    <h4>
                        <?php
                            if($row['id'] == $idlogin){
                                ?>
                                <a href="index.php?id=<?php echo $row['id'] ?>"><?php echo 'you' ?></a>
                                <?php
                            }else{
                                ?>
                                <a href="index.php?id=<?php echo $row['id'] ?>"><?php echo $row['Name'] ?></a>
                                <?php
                            }
                        ?>
                        
                    </h4>
                </div><!--end div.panel-heading-->
                <div class="panel-body panel-friend">
                    <?php
                    $stmt2 = $con->prepare('SELECT users.* from users,friends WHERE friends.friend1 = users.id AND friends.friend2= :id AND friends.friend2 = :login');
                    $stmt2->execute(array(
                        'id'=>$row['id'],
                        'login'=>$idlogin
                    ));
                    $rowsFFriend = $stmt2->fetchAll();
                    
                    if($stmt2->rowCount()){
                    echo '<p>Common Friends</p>';
                    foreach($rowsFFriend as $rowfffriend){
                        
                        ?>
                        
                        <a href="index.php?id=<?php echo $rowfffriend['id']?>"><img src="data\uploads\images\<?php echo $rowfffriend['image'] ?>" alt="" class="img-circle img-ffriend"></a>
                        <?php
                    }
                }
                    ?>
                 
                </div>
                <div class="panel-heading" style="min-height: 51px;">
                    <?php
                        $smtAddFriend = $con->prepare('SELECT * FROM friends where friends.friend1 =:friend1 AND friends.friend2 = :friend2');
                        $smtAddFriend->execute(array(
                            'friend1'=>$row['id'],
                            'friend2'=>$idlogin
                        ));
                        $countAddFriend = $smtAddFriend->rowCount();
                        


                        if(($row['id']!==$idlogin)){   
                        if($countAddFriend>0){
                            
                            //if($row['id']!==$idlogin){
                            ?>  
                                <div class="addFriend">
                                    <div class="btn btn-danger btnAddFriend" data-id="<?php echo $row['id']?>">Remove Friend</div>
                                    <p style="display:inline;">1,299 people friend</p>
                                </div>
                            <?php
                        }else{

                            ?>  
                        
                                <div class="addFriend">
                                    <div class="btn btn-default btnAddFriend" data-id="<?php echo $row['id']?>">+add friend</div>
                                    <p style="display:inline;">1,299 people friend</p>
                                </div>
                            <?php
                        }
                    }
                    ?>
                </div><!--end div.panel-heading-->
            </div>
        </div><!--end div.friend-list-->
        <?php
            
        }
        ?>
    </div><!--end div.col-md-9-->
<?php
    include $tpl.'footer2.php';
    }else{
        header('Location: login.php');
    }
?>