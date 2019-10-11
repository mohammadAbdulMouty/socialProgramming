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
        if($_GET['status']==1){
        $rand =rand(0,1000000);
        
        $stmt =$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,0,:userid)');
        $stmt->execute(array(
            "id"=>$rand,
            "body"=>$_GET['body'],
            'userid'=>$idlogin
        ));
        if(isset($_FILES['file'])){
        foreach($_FILES['file']['tmp_name'] as $key=>$value){
            $randNameImg=rand(0,1000000);
            
            
            $name = $_FILES['file']['name'][$key];
            $tmp = $_FILES['file']['tmp_name'][$key];
            $nameImage = $randNameImg.'_'.$name;
            $stmt2=$con->prepare('INSERT INTO `post_image`(`image_name`, `post_id`) VALUES (:imgName,:postid)');
            $stmt2->execute(array(
                "imgName"=>$nameImage,
                "postid"=>$rand
            ));
            move_uploaded_file($tmp,'data\uploads\images\\'.$nameImage);
        }
        }
        }
        if($_GET['status']==2){
            $code = $_POST['code'];
            $postText = $_POST['postText'];
            $selectlangVal = $_POST['selectval2'];
            $rand =rand(0,1000000);
            $stmt =$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,1,:userid)');
            $stmt->execute(array(
                "id"=>$rand,
                "body"=>$postText,
                "userid"=>$idlogin
            ));
            $stmtCode = $con->prepare('INSERT INTO `code_post`(`code`, `language`, `post_id`) VALUES (:code,:lang,:postid)');
            $stmtCode->execute(array("code"=>$code,"lang"=>$selectlangVal,"postid"=>$rand));
        }
        if($_GET['status']==3){
            $desc = $_POST['desc'];
            $fileName = $_POST['name'];
            $rand =rand(0,1000000);
            $stmt2 =$con->prepare('INSERT INTO `posts`(`id`,`body`, `post_at`, `likes`, `status`, `user_id`) VALUES (:id,:body,now(),0,1,:userid)');
            $stmt2->execute(array(
                "id"=>$rand,
                "body"=>$desc,
                "userid"=>$idlogin
            ));
            $type =substr($fileName,strrpos($fileName,'.')+1);
            $stmt3 = $con->prepare('INSERT INTO `post_file`(`file_name`,`type`, `post_id`) VALUES (:filename,:type,:postid)');
            $stmt3->execute(array(
            'filename'=>$fileName,
            'postid'=>$rand,
            'type'=>$type

            ));

        }
        if($_GET['status']==4){
            $idpost = (int)$_POST['postid'];
            $stmtDelete = $con->prepare('DELETE FROM `posts` WHERE id =:postid');
            $stmtDelete->bindParam(':postid',$idpost,PDO::PARAM_INT);
            $stmtDelete->execute();
        }
    }

    $stmt = $con->prepare("SELECT users.Name,users.image ,posts.* from users INNER JOIN posts ON users.id = user_id AND posts.status =0 ORDER BY posts.post_at DESC");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    foreach($rows as $row){
    ?>

    <div class="post-ajax">
        <div class="row">
        <Div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="read-post">
                <div class="info-img">
                    <img  src="data\uploads\images\<?php echo $row['image']  ?>" />
                    <a href=""><?php echo $row['Name']  ?></a>
                    <span class="date-post"><?php echo dateGo($row['post_at']) ?></span>
                    <div class="change-post pull-right">
                        <i class="fa fa-close fa-fw btn-delete-post"></i>
                        <i class="fa fa-edit fa-fw btn-edit-post"></i>
                    </div>
                </div>
                <hr style="margin-top: 3px;">
                <div class="post-body" data-id="<?php echo $row['id'] ?>">
                    <p><?php echo $row['body'] ?></p>
                </div>
                <?php 
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
                        }
                    

                    ?>
            
                <?php
                    if($countCode>0){
                        $codee = htmlspecialchars($rowCode['code'], ENT_QUOTES);
                        $codee =preg_replace("/\\n/m", "<br />", $codee);
                       
                        echo '<pre><code data-par="'.$rowCode['id'].'" class="'.$rowCode['language'].'" >'.$codee.'</code><span class="glyphicon glyphicon-fullscreen"></span></pre>';
                        
                        
                    }
                    
                    if($countFile > 0){
                        echo '<div class="show-file">';
                        echo '<a href="data/uploads/files/'.$rowsFile[0]['file_name'].'">';
                        if($rowsFile[0]['type'] == 'pdf'){
                        echo '<i class="fa fa-file-pdf-o"></i></a>';
                        }else if($rowsFile[0]['type'] == 'txt'){
                            echo '<i class="fa fa-file-text"></i></a>';
                        }
                        echo '<p>'.substr($rowsFile[0]['file_name'],strpos($rowsFile[0]['file_name'],'_')+1).'</p>';
                        echo '</div>';
                        
                    }

                ?>
                <hr>
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
                    <span class="badge btn-dislike"><i class="fa fa-thumbs-o-down"> <?php echo $row['dislike']?></span></i></span>
                    <?php
                        }
                    ?>
                    <span ><i class="fa fa-share" style="float: right;margin-right: 10px;margin-top: 6px;"></i></span>
                </div><!--end div.like-or-dislike-->
            <hr style="margin-top:0px">
            <div class="panel panel-default btn-show-comments">
                    <div class="panel-body text-center">Show Comments</div>
            </div><!--end div.btn-show-comments-->
            <div class="comments">
                    <div class="write-comment">
                        <img  src="data\uploads\images\default.jpg" />
                        <textarea placeholder="write the comment" class="editMesaage" rows="" cols=""></textarea>
                    </div><!--end div.write-comment-->
                    <hr style="margin-top:0">
                    <div class="comment-displayAjax">

                    </div>
            </div><!--end div.comment-->
            </div><!--end the div.readpost-->
        </div><!--end the div.col-md-9-->
        </div><!--end the div.row-->
        <script>
            var block = document.getElementById('codedis');
            Prism.highlightElement(block);
        </script>
    </div><!--end div.post-ajax-->

    <?php
    }
    include $tpl.'footer.php';
}
?>