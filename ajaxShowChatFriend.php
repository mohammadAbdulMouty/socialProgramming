<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     $stmtcount = $con->prepare('SELECT * From chat where (user_send =:usersend AND user_to =:userto) OR (user_send =:userto AND user_to =:usersend)');
     $stmtcount->bindParam(':usersend',$idlogin,PDO::PARAM_INT);
     $stmtcount->bindParam(':userto',$_POST['fid'],PDO::PARAM_INT);
     $stmtcount->execute();
     $count = $stmtcount->rowCount();
     if($_GET['status']==1){
     if($count-$_POST['end']<0){
         $countFinsh = 0;
     }else{
         $countFinsh = $count-$_POST['end'];
     }
    $stmt2 = $con->prepare("SELECT * FROM chat WHERE (user_send =:usersend AND user_to =:userto) OR (user_send =:userto AND user_to =:usersend) ORDER BY mesg_at LIMIT :offset
    ,10");
    $stmt2->bindParam(':usersend',$idlogin,PDO::PARAM_INT);
    $stmt2->bindParam(':userto',$_POST['fid'],PDO::PARAM_INT);
    // $stmt2->bindParam(':limt',$_POST['start'],PDO::PARAM_INT);
     $stmt2->bindValue(':offset',$countFinsh,PDO::PARAM_INT);
    $stmt2->execute();
    $count = $stmt2->rowCount();
    $rows1 = $stmt2->fetchAll();
    if($count>0){
        
        foreach($rows1 as $rowr){
            
            
            if($rowr['user_send'] == $idlogin){
                
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
            if($rowr['user_to'] == $idlogin){
                
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
     }else if($_GET['status'] == 2){
        
        if($count-$_POST['end']<0){
            $countFinsh = 0;
        }else{
            $countFinsh = $count-$_POST['end'];
        }

       $stmt2 = $con->prepare("SELECT * FROM chat WHERE (user_send =:usersend AND user_to =:userto) OR (user_send =:userto AND user_to =:usersend) ORDER BY mesg_at LIMIT :offset
       ,10");
       $stmt2->bindParam(':usersend',$idlogin,PDO::PARAM_INT);
       $stmt2->bindParam(':userto',$_POST['fid'],PDO::PARAM_INT);
       // $stmt2->bindParam(':limt',$_POST['start'],PDO::PARAM_INT);
        $stmt2->bindValue(':offset',$countFinsh,PDO::PARAM_INT);
       $stmt2->execute();
       $count = $stmt2->rowCount();
       $rows1 = $stmt2->fetchAll();
       if($count>0){
          
           foreach($rows1 as $rowr){
               
               
               if($rowr['user_send'] == $idlogin){
                   
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
               if($rowr['user_to'] == $idlogin){
                   
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

    }