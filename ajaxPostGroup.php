<?php
include 'connect.php';
include 'includes/functions/function.php';
if(isset($_COOKIE['SPID'])){

    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    $stmtJoin = $con->prepare('SELECT * From user_group WHERE user_id=:id AND Group_id = :groupid');
    $stmtJoin->bindParam(':id',$idlogin,PDO::PARAM_INT);
    $stmtJoin->bindParam(':groupid',$_GET['gid'],PDO::PARAM_INT);
    $stmtJoin->execute();
    if($stmtJoin->rowCount() >0){
    if(isset($_GET['status'])){
        
        if($_GET['status'] == 1){
            if(isset($_FILES['file'])){
                $count = count($_FILES['file']['tmp_name']);
                
            }else{
                $count = 0;
            }
            if(empty($_POST['post']) && $count<=0 ){
                die();
            }else{
            $idGroup = $_POST['idgroup'];
            
            $rand = rand(0,10000000);
            $stmt=$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,1,:userid)');
            $stmt->bindParam(':id',$rand,PDO::PARAM_INT);
            $stmt->bindParam(':body',$_POST['post'],PDO::PARAM_STR);
            $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
            $stmt->execute();
            $stmt2=$con->prepare('INSERT INTO `post_group`(`post_id`, `group_id`) VALUES (:postid,:groupid)');
            $stmt2->bindParam(':postid',$rand);
            $stmt2->bindParam(':groupid',$idGroup,PDO::PARAM_INT);
            $stmt2->execute();
            if(isset($_FILES['file']['tmp_name'])){
                foreach($_FILES['file']['tmp_name'] as $key=>$val){
                    $randNameImg=rand(0,1000000);
                    $name = $_FILES['file']['name'][$key];
                    $tmp = $_FILES['file']['tmp_name'][$key];
                    $nameImage = $randNameImg.'_'.$name;
                    $stmtImg = $con->prepare('INSERT INTO `post_image`(`image_name`, `post_id`) VALUES (:imgName,:postid)');
                    $stmtImg->bindParam(':imgName',$nameImage,PDO::PARAM_STR);
                    $stmtImg->bindParam(':postid', $rand,PDO::PARAM_INT);
                    $stmtImg->execute();
                    move_uploaded_file($tmp,'data\uploads\images\\'.$nameImage);
                }
            }
        }
       
         
    }//end to upload the post imge group
    else if($_GET['status']==2){
        $idgroup = $_POST['idGroup'];
        $selVal = $_POST['selectVal'];
        $textareaVal = $_POST['textareaVal'];
        $codeVal = $_POST['codeVal'];
        $rand = rand(0,10000000);
        $stmt=$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,1,:userid)');
        $stmt->bindParam(':id',$rand,PDO::PARAM_INT);
        $stmt->bindParam(':body',$textareaVal,PDO::PARAM_STR);
        $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
        $stmt->execute();
        $stmt2=$con->prepare('INSERT INTO `post_group`(`post_id`, `group_id`) VALUES (:postid,:groupid)');
        $stmt2->bindParam(':postid',$rand);
        $stmt2->bindParam(':groupid',$idgroup,PDO::PARAM_INT);
        $stmt2->execute();
        $insertCode = $con->prepare('INSERT INTO `code_post`(`code`, `language`, `post_id`) VALUES (:code,:lang,:postid)');
        $insertCode->bindParam(':code',$codeVal,PDO::PARAM_STR);
        if($selVal == 'JavaScript'){
            $selVal = 'NodeJS';
        }
        $insertCode->bindParam(':lang',$selVal,PDO::PARAM_STR);
        $insertCode->bindParam(':postid',$rand,PDO::PARAM_INT);
        $insertCode->execute();
        

    }//end to upload the post Code group
    else if($_GET['status']==3){
       $fileName = $_POST['fileName'];
       $extenstion =  substr($fileName,strrpos($fileName,'.')+1);
       $idGroup = $_POST['idGroup'];
       $descripe = $_POST['descripe'];
        $rand = rand(0,10000000);
        $stmt=$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,1,:userid)');
        $stmt->bindParam(':id',$rand,PDO::PARAM_INT);
        $stmt->bindParam(':body',$descripe,PDO::PARAM_STR);
        $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
        $stmt->execute();
       $stmt2=$con->prepare('INSERT INTO `post_group`(`post_id`, `group_id`) VALUES (:postid,:groupid)');
       $stmt2->bindParam(':postid',$rand);
       $stmt2->bindParam(':groupid',$idGroup,PDO::PARAM_INT);
       $stmt2->execute();
       $insertFile = $con->prepare('INSERT INTO `post_file`(`file_name`,`type`,`post_id`) VALUES (:fileName,:type,:postid)');
       $insertFile->bindParam(':fileName',$fileName,PDO::PARAM_STR);
       $insertFile->bindParam(':type',$extenstion,PDO::PARAM_STR);
       $insertFile->bindParam(':postid',$rand,PDO::PARAM_INT);
       $insertFile->execute();
    
    }else if($_GET['status']==4){
        include 'connect.php';
        $stmt = $con->prepare('DELETE FROM `posts` WHERE id=:id');
        $stmt->bindParam(':id',$_GET['pid'],PDO::PARAM_INT);
        $stmt->execute();
    }
    }
    $groupId = $_GET['gid'];
    $stmt = $con->prepare("SELECT users.Name,users.id as userid,users.image ,posts.* ,post_group.* from users INNER JOIN posts ON users.id = user_id AND posts.status =1 INNER JOIN post_group ON post_group.post_id = posts.id WHERE post_group.group_id =:groupId   ORDER BY posts.post_at DESC");
    $stmt->bindParam(':groupId',$groupId,PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $countStmtPostGroup = $stmt->rowCount();
 
    
    if($countStmtPostGroup >0){
        
        foreach($rows as $row){
            
            $stmtdisp = $con->prepare('SELECT  `image_name` FROM `post_image` WHERE `post_id`=:postid');
            $stmtdisp->execute(array(
                "postid"=>$row['id']
            ));
            $rowsDisp = $stmtdisp->fetchAll();
            $countdisp =$stmtdisp->rowCount();
            $stmtCode = $con->prepare('SELECT  * FROM `code_post` WHERE post_id = :postidd');
            $stmtCode->execute(
                array(
                    ':postidd'=>$row['id']
                )
                );
            $rowCode = $stmtCode->fetch();
            $countCode =  $stmtCode->rowCount();

            $stmtFile = $con->prepare('SELECT * FROM post_file WHERE post_id = :postid');
            $stmtFile->execute(array(':postid'=>$row['id']));
            $rowsFile = $stmtFile->fetchAll();
            $countFile = $stmtFile->rowCount();
        ?>
        
            <div class="panel panel-default col-lg-5 col-md-9 col-sm-5 col-xs-12 post-group-item" data-pid="<?php echo $row['id'] ?>">
            <div class="panel-heading user-post-group ">
                <a href="http://sprogramming/?id=<?php echo $row['userid'] ?>">
                    <img src="data\uploads\images\<?php echo $row['image']  ?>">
                    <p><?php echo $row['Name'] ?></p>
                    
                </a>
               
                <p class="date-post-group"><?php echo dateGo($row['post_at'])  ?></p>
            <?php 
                if($row['userid'] == $idlogin){
                    ?>
                <span class="delete-post" data-pid="<?= $row['id']?>" data-gid="<?= $_GET['gid'] ?>"><i class="fa fa-close"></i></span>
                <?php } ?>
            </div><!--end div.panel-heading-->
            <div class="panel-body">
                <div class="post-body" data-id="<?php echo $row['id']  ?>">
                <p class="pargraph-post"><?php echo $row['body'] ?></p>
                <?php
                if($countdisp>0){
                        ?>
                        <div class="display_imge" style="position:relative">
                        <?php
                        
                            if($countdisp>1){
                                echo '<i class="fa fa-arrow-circle-right next" style="right: 30px;top: 113px;font-size: 28px;position: absolute;"></i>';
                                echo '<i class="fa fa-arrow-circle-left prev" style="left: 30px;top: 113px;font-size: 28px;position: absolute;"></i>';
                            }
                            for($i = 0;$i<count($rowsDisp);$i++){
                                if($i == 0){
                                    $class="active";
                                }else{
                                    $class="";
                                }
                            echo '<img src="data/uploads/images/'.$rowsDisp[$i]['image_name'].'" class="'.$class.'" data-fin="'.$i.'" alt="" class="img-responsive" style="max-height:300px;max-width:100%;margin: 0 auto;">';
                            }
                            echo '</div>';
                        }
                        if($countCode>0){
                            $codee = htmlspecialchars($rowCode['code'], ENT_QUOTES);
                            $countWord =  strlen($codee);
                            if($countWord >100){
                                $codee=substr($codee,0,100).'....etc';
                            }
                            $codee =preg_replace("/\\n/m", "<br />", $codee);
                            if(!empty($codee)){
                            echo '<pre data-par="'.$rowCode['id'].'"><span class="lang-name">'.$rowCode['language'].'</span><code data-par="'.$rowCode['id'].'" class="'.$rowCode['language'].'" >'.$codee.'</code><div class="full-screen-code"><span class="glyphicon glyphicon-fullscreen"></span></div></pre>';
                            echo '';
                            }
                            
                        }
                        if($countFile > 0){
                            echo '<div class="show-file">';
                            
                            echo '<a href="data/uploads/files/'.$rowsFile[0]['file_name'].'">';
                            if($rowsFile[0]['type'] == 'pdf'){
                                echo '<i class="fa fa-file-pdf-o" style="color:#c33f3f"></i></a>';
                                }else if($rowsFile[0]['type'] == 'txt'){
                                    echo '<i class="fa fa-file-text" style="color:#23527c"></i></a>';
                                }
                            echo '<p>'.substr($rowsFile[0]['file_name'],strpos($rowsFile[0]['file_name'],'_')+1).'</p>';
                            echo '</div>';
                            
                        }
            ?>
            </div><!--end div.post-body-->
            </div><!--end div.panel-body-->
            <div class="panel-footer">
            <div class="like-or-dislike">
                    <?php
                        $stmtLike = $con->prepare('SELECT * FROM post_like WHERE post_id=:postid and user_id = :userid ');
                        $stmtLike->execute(
                            array(":postid"=>$row['id'],
                            ":userid"=>$idlogin
                            )
                        );
                        $rowlike =$stmtLike->fetchAll();
                        $rowlikeCount = $stmtLike->rowCount();
                        if($rowlikeCount>0){
                            if($rowlike[0]['status']==1){
                                ?>
                                    <span class="badge btn-like like-active"><i class="fa fa-thumbs-o-up"> <?php echo $row['likes']?></i></span>
                                    <span class="badge btn-dislike"><i class="fa fa-thumbs-o-down"> <?php echo $row['dislike'] ?></i></span>
                                <?php
                            }else if($rowlike[0]['status']==2){
                                ?>
                                 <span class="badge btn-like "><i class="fa fa-thumbs-o-up"> <?php echo $row['likes']  ?></i></span>
                                <span class="badge btn-dislike dislike-active"><i class="fa fa-thumbs-o-down"> <?php echo $row['dislike'] ?></span></i></span>
                                <?php
                            }
                        }else{
                            
                    ?>
                    <span class="badge btn-like"><i class="fa fa-thumbs-o-up"> <?php echo $row['likes']?></i></span>
                    <span class="badge btn-dislike"><i class="fa fa-thumbs-o-down"> <?php echo $row['dislike']?></i></span>
                    <?php
                        }
                    ?>
                    <span ><i class="fa fa-commenting-o btn-show-comment-group" style="float: right;margin-right: 10px;margin-top: 6px;"></i></span>
                </div><!--end div.like-or-dislike-->
                
                    </div>
                <div class="comment-group">
                
                    <div id="loadingProgressG">
                            <div id="loadingProgressG_1" class="loadingProgressG"></div>
                    </div><!--end div#loadingProgressG-->
                    <div class="comments-read">
                                
                                <div class="comments-elements-container">
                                   
                                </div><!--end div.comments-elements-container-->
                                
                    </div>  
                </div><!--end div.comment-group-->
            </div>
            </div><!--end div.panel-defaul-->
        
        

        <?php
        }
    }else{
        echo '<div class="alert alert-info alert-noPost">No Post In this Group</div>';
    }







}else{
    echo '<div class="alert alert-danger alert-notjoin">Please Join group to see Post</div>';
}


}