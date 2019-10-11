<?php
include 'init.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $rand =rand(0,1000000);
     $idlogin = $rowlogin[0]['id'];
     $idPost = $_POST['postid'];
     $textarea = $_POST['textarea'];
    $stmt2= $con->prepare('INSERT INTO `comments`(`cid`,`name`,`date`, `body`, `userid`, `postid`) VALUES (:id,:name,now(),:body,:userid,:postid)');
    $stmt2->bindParam(':name',$rowlogin[0]['Name'],PDO::PARAM_STR);
    $stmt2->bindParam(':id',$rand,PDO::PARAM_INT);
    $stmt2->bindParam(':body',$textarea,PDO::PARAM_STR);
    $stmt2->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt2->bindParam(':postid',$idPost,PDO::PARAM_INT);
    $stmt2->execute();
    $stmt3 = $con->prepare('SELECT * FROM `comments` WHERE `cid`=:cid');
    $stmt3->bindParam(':cid',$rand,PDO::PARAM_INT);
    $stmt3->execute();
    $rows = $stmt3->fetchAll();
    ?>
    <div class="comment-element">
        <a href=""><img src="data/uploads/images/default.jpg"><h5><?php echo $rows[0]['name'] ?></h5></a>
        <p class="date-comment"><?php echo dateGo($rows[0]['date']) ?></p>
        <div class="comment-body">
            <p><?php echo $rows[0]['body'] ?></p>
        </div>
        <hr style="margin-top: 0;margin-bottom: 0;">
    </div><!--end div.comment-element -->
<?php
     





    }