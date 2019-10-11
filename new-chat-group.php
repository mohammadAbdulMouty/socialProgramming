<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    
    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    $stmt = $con->prepare('SELECT `message`, `date` FROM `chat-group-content` WHERE `userid` = :userid AND `group-chat` =:groupchat');
    $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt->bindParam(':groupchat',$_GET['frid'],PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $count = $stmt->rowCount();
    if($count>0){
       
        foreach($rows as $rowr){
            
            
            if($rowr['userid'] == $idlogin){
                
                ?>
                <div class="content-message">
                <img src="data\uploads\images\default.jpg" class="img-message-user">
                <span class="span-you"></span>
                <div class="alert alert-success alert-you">
                <?= $rowr['message']?>
                </div>
                </div>
                <?php
            }
            else{
                
                ?>
                
                <div class="content-message content-not-you">
                
                <div class="alert alert-info alert-not-you">
                <?= $rowr['message']?>
                </div>
                <img src="data\uploads\images\default.jpg" class="img-message-user">
                <span class="span-not-you"></span>
                </div><!--end div.content-message-->
                <?php
            }
            
        }

    }else{
        echo '<div class="alert alert-danger noMessage">NO MESSAGE</div>';
    } 



}