<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    
    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
require 'includes/libraries/pusher/Pusher.php';

  $options = array(
    'encrypted' => true
  );




    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    $pusher = new Pusher\Pusher(
        '22fb4c1174b8f33a27d4',
        'f7d981fec1c5b26fa300',
        '449856',
        $options
      );
      $data['message'] = $_POST['val'];
      $data['to'] = $_POST['idto'];
      $data['from'] = $idlogin;
      $pusher->trigger('my-channel', 'my-event', $data);
    $stmt2 = $con->prepare('INSERT INTO `chat`(`user_send`, `user_to`, `message`, `mesg_at`) VALUES (:useridlogin,:idto,:messagge,now())');
    $stmt2->bindParam(':useridlogin',$idlogin,PDO::PARAM_INT);
    $stmt2->bindParam(':idto',$_POST['idto'],PDO::PARAM_INT);
    $stmt2->bindParam(':messagge',$_POST['val'],PDO::PARAM_INT);
    $stmt2->execute();
  

}