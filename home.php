<?php 
session_start();
$navTop = '';
$ActiveHome = '';
$pageTitle = 'Home';
include 'init.php';
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    include $tpl.'navbar.php';
    ?>
    <div class="container container-home">
    <div class="post-home-timeline">
    <?php
        $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmtcookies->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        $rowlogin =$stmtcookies->fetchAll();
        $idlogin = $rowlogin[0]['id'];
        $stmt11= $con->prepare('SELECT posts.*, users.* FROM posts INNER JOIN users ON users.id = posts.user_id INNER JOIN friends on users.id = friends.friend1 WHERE friends.friend2 =:idlogin');
        $stmt11->bindParam(':idlogin',$idlogin,PDO::PARAM_INT);
        $stmt11->execute();
        $rows = $stmt11->fetchAll();
        $count = $stmt11->rowCount();
       if($count >0){
           var_dump($rows);
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
         <div class="panel panel-default col-lg-5 col-md-4 col-sm-4 col-xs-12 post-home-item" data-pid="<?php echo $row['id'] ?>">
            <div class="panel-heading user-post-group ">
            <a href="http://sprogramming/?id=<?php echo $row['userid'] ?>">
            <img src="data\uploads\images\<?php echo $row['image']  ?>">
            <p><?php echo $row['Name'] ?></p>
            </a>
            <p class="date-post-group"><?php echo dateGo($row['post_at'])  ?></p>
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
                        <span class="badge btn-dislike"><i class="fa fa-thumbs-o-down"> <?php echo $row['dislike']?></span></i></span>
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
           
                    
                    
            
                    <?php
                    }
                }else{
                    echo '<div class="alert alert-info">No Post In this Group</div>';
                }



                ?>
            </div><!--end div.post-home-timeline-->
        </div><!--end div.container-home-->
        </div><!--end div.container-home-->
        </div>
    <?php
    }
  



include $tpl.'footerHome.php';