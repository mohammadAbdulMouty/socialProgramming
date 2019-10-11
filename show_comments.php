
<?php 
    include 'init.php';
    if(isset($_COOKIE['SPID'])){
        $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmtcookies->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        
        $rowlogin =$stmtcookies->fetchAll();
        $idlogin = $rowlogin[0]['id'];

    if(isset($_GET['status'])){
        if($_GET['status'] == 1){
      
        $postid = $_GET['postid'];
        $name = $rowlogin[0]['Name'];
         $commentbody = $_GET['body'];
        $InsertParent = $con->prepare('INSERT INTO `comments`(`name`, `date`, `body`, `userid`, `postid`) VALUES (:name,now(),:body,:userid,:postid) ');
        $InsertParent->execute(array(
            ':name'=>$name,
            ':body'=>$commentbody,
            ':userid'=>$idlogin,
            ':postid'=>$postid
        ));
        }else if($_GET['status'] == 2){
            
            $parentCommentID = $_GET['prentId'];
            $childVal = $_GET['childval'];
            $insertComm = $con->prepare('INSERT INTO `child_comments`(`name`, `date`, `body`, `parent`) VALUES (:name,now(),:body,:parent)');
            $insertComm->execute(array(
                'name'=>$rowlogin[0]['Name'],
                'body'=>$childVal,
                'parent'=>$parentCommentID
            ));
        }
    }
    }






    $stmt = $con->prepare('SELECT * FROM `comments` WHERE postid = :postid');
    var_dump($_GET['postid']);
    $stmt->execute(array(':postid'=>$_GET['postid']));
    $rows = $stmt->fetchAll();
    var_dump($rows);
    foreach($rows as $row){
?>

                <div class="read-comment">
                
                    <div class="comment-list">
                        <div class="comment-group">
                            <div class="comment-parent">
                                <div class="user-img" style="float: left;">
                                    <img src="data\uploads\images\male-avatar1.png" class="comment-user-img" style="width: 32px;height: 32px;">
                                </div><!--end div.user-img-->
                                <div class="comment-body">
                                    <h4 class="username-field" style="font-size:14px" >
                                        <a href="#"><?php echo $row['name']?></a>
                                    </h4>
                                    <div class="comment-text" data-parent="<?php echo $row['cid'] ?>">
                                        <?php echo $row['body'];?>
                                    </div><!--end div.comment-text-->
                                    <div class="arrow-comment"></div>
                                    <span>replay</span>
                                </div><!--end div.comment-parent-->
                                <?php
                                 $stmt2 =$con->prepare('SELECT * FROM `child_comments` WHERE parent = :parent');
                                 $stmt2->execute(array(':parent'=>$row['cid']));
                                 $rows2 = $stmt2->fetchAll();
                                
                                 if(!empty($rows2)){
                                        foreach($rows2 as $row2){
                                        ?>
                                        <div class="child-comment" style="margin-left: 100px;" >
                                        <div class="user-img" style="float: left;">
                                            <img src="data\uploads\images\male-avatar1.png" class="comment-user-img" style="width: 32px;height: 32px;">
                                        </div><!--end div.user-img-->
                                        <div class="list-child-comment">
                                            <div class="comment-body">
                                                <h4 class="username-field" style="font-size:14px" >
                                                    <a href="#"><?php echo $row2['name'] ?></a>
                                                </h4>
                                                <div class="comment-text">
                                                <?php echo $row2['body'] ?>
                                                </div><!--end div.comment-text-->
                                                <div class="arrow-comment"></div>
                                                <span>replay</span>
                                                
                                            </div><!--end div.comment-body-->
                                            <img src="data\uploads\images\male-avatar1.png" class="comment-user-img" style="width: 32px;height: 32px;">
                                            <textarea class="child-textarea" rows="" cols=""></textarea>
                                        </div>
                                    </div><!--end div.comment-child-->
                                    <?php
                                        }
                                        }else{
                                            ?>
                                        <div class="child-comment" style="margin-left: 100px;">
                                        <div class="list-child-comment">
                                            <div class="comment-body">
                                            </div><!--end div.comment-body-->
                                            <img src="data\uploads\images\male-avatar1.png" class="comment-user-img" style="width: 32px;height: 32px;">
                                            <textarea class="child-textarea" rows="" cols=""></textarea>
                                        </div>
                                    </div><!--end div.comment-child-->
                                            <?php
                                        }
    

                                    ?>
                                    </div><!--end div.comment-body-->
                                </div><!--end div.comment-group-->    
                            </div><!--end div.comment-list-->
                        </div><!--end div.read-comment-->


        <?php
                }                 
                                
                            
 ?>