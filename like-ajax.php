<?php
include 'connect.php';
 if(isset($_COOKIE['SPID'])){
        
        $counterLike= 0;
        $counterDislike = 0;
        $likeActive = '';
        $dislikeActive ='';
        $stmtpost = $con->prepare('SELECT * FROM posts WHERE id =:id');
        $stmtpost->execute(array(':id'=>$_GET['idpost']));
        $rowsPOST = $stmtpost->fetchAll();
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmt->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        $rowlogin = $stmt->fetchAll();
        $idlogin = $rowlogin[0]['id'];
        $stmtsearch = $con->prepare('SELECT * FROM post_like WHERE post_id =:postid AND user_id =:userid');
        $stmtsearch->execute(array('postid'=>$_GET['idpost'],'userid'=>$idlogin));
        $rowserach = $stmtsearch->fetchAll();
        $stmtCount = $stmtsearch->rowCount();

   if($_GET['do']=='like'){   
        if($_GET['status']=='notActive'){
            if($stmtCount>0){
                $updateStmt = $con->prepare('UPDATE `post_like` SET `status`=:status WHERE user_id = :userid AND post_id = :postid');
                $updateStmt->execute(array('status'=>1,'userid'=>$idlogin,'postid'=>$_GET['idpost']));
                $counterDislike = -1;
                $likeActive='like-active';
                $counterLike = +1;
            }else{
            $stmtLikeAjax = $con->prepare('INSERT INTO `post_like`(`post_id`, `status`, `user_id`) VALUES (:postid,1,:idlogin)');
            $stmtLikeAjax->execute(array(
                'postid'=>$_GET['idpost'],
                'idlogin'=>$idlogin
            ));
            $likeActive='like-active';
            $counterLike = +1;
        }
        }else if($_GET['status']=='active'){
            if($stmtCount>0){
                $stmtLikeAjax = $con->prepare('DELETE FROM `post_like` WHERE user_id=:userid AND post_id =:postid');
                $stmtLikeAjax->execute(array(
                    'userid'=>$idlogin,
                    'postid'=>$_GET['idpost']
                ));
                $likeActive='';
                $counterLike = -1;
            }else{
                $stmtLikeAjax = $con->prepare('INSERT INTO `post_like`(`post_id`, `status`, `user_id`) VALUES (:postid,1,:idlogin)');
                $stmtLikeAjax->execute(array(
                    'postid'=>$_GET['idpost'],
                    'idlogin'=>$idlogin
                ));
                $likeActive='like-active';
                $counterLike = +1;
            }
        }
        $stmtpostUpdate = $con->prepare('UPDATE `posts` SET `likes`=:likess,`dislike`=:dislikes WHERE id = :idd');
        $stmtpostUpdate->execute(array(
            'likess'=>$rowsPOST[0]['likes']+$counterLike,
            'dislikes'=>$rowsPOST[0]['dislike']+$counterDislike,
            'idd'=>$_GET['idpost']
        ));
    }else if($_GET['do']=='dislike'){
        if($_GET['status']=='notActive'){
            if($stmtCount>0){
                $updateStmt = $con->prepare('UPDATE `post_like` SET `status`=:status WHERE user_id = :userid AND post_id = :postid');
                $updateStmt->execute(array('status'=>2,'userid'=>$idlogin,'postid'=>$_GET['idpost']));
                $counterDislike = +1;
                $dislikeActive='dislike-active';
                $counterLike = -1;
            }else{
            $stmtLikeAjax = $con->prepare('INSERT INTO `post_like`(`post_id`, `status`, `user_id`) VALUES (:postid,2,:idlogin)');
            $stmtLikeAjax->execute(array(
                'postid'=>$_GET['idpost'],
                'idlogin'=>$idlogin
            ));
            $dislikeActive='dislike-active';
            $counterDislike = +1;
            }
        }else if($_GET['status']=='active'){
            
            $stmtLikeAjax = $con->prepare('DELETE FROM `post_like` WHERE user_id=:userid AND post_id =:postid');
            $stmtLikeAjax->execute(array(
                'userid'=>$idlogin,
                'postid'=>$_GET['idpost']
            ));
            $dislikeActive='';
            $counterDislike = -1;
        }
        $stmtpostUpdate = $con->prepare('UPDATE `posts` SET `likes`=:likess,`dislike`=:dislikes WHERE id = :idd');
        $stmtpostUpdate->execute(array(
            'likess'=>$rowsPOST[0]['likes']+$counterLike,
            'dislikes'=>$rowsPOST[0]['dislike']+$counterDislike,
            'idd'=>$_GET['idpost']
        ));
    }
    ?>

    <span class="badge btn-like <?php echo $likeActive ?>"><i class="fa fa-thumbs-o-up"> <?php echo $rowsPOST[0]['likes']+$counterLike?></i></span>
    <span class="badge btn-dislike <?php echo $dislikeActive ?>"><i class="fa fa-thumbs-o-down"> <?php echo $rowsPOST[0]['dislike']+$counterDislike?></span></i></span>
    <span ><i class="fa fa-commenting-o btn-show-comment-group" style="float: right;margin-right: 10px;margin-top: 6px;"></i></span>
    <?php
}?>