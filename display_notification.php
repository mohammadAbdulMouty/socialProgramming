<?php
if(isset($_COOKIE['SPID'])){
    include 'connect.php';
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     $stmt = $con->prepare('SELECT * FROM notification INNER JOIN notification_read ON notification.not_Id = notification_read.notif_id  WHERE notification_read.status =0 AND notification.user_id =:userid');
     $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
     $stmt->execute();
     $rows2 = $stmt->fetchAll();
     foreach($rows2 as $rows){
         ?>
        <div class="alert alert-info alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Info!</strong> This alert box could indicate a neutral informative change or action.
        </div>


<?php
     }

    }