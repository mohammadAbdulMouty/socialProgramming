<?php

if(isset($_COOKIE['SPID'])){
    $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmtcookies->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin =$stmtcookies->fetchAll();
    $idlogin = $rowlogin[0]['id'];
    

}

?>
<!-- <script>
    setInterval(function(){
       xml = new XMLHttpRequest();
       xml.onreadystatechange = function(){
        if(xml.readyState == 4 && xml.status == 200){
            $('.container-not .not-count').html(xml.responseText);
        }

       }
       xml.open('POST','ajaxNotification.php');
       xml.send();
        
    },10000)

    </script> -->
    <?php

    


    if(!isset($noNotfication)){
        
   
    ?>
    <div class="chat-not">
        <div class="container-not">
            <div class="not-count">
                
            </div>
            <div class="not">
                
                    <span class="rotate">Notification</span>
                    
            </div>
        </div>
        <div class="container-chat">
            <div class="chat"><div class="rotate">Chat</div></div>
        </div>
    </div><!--end div.chat-not-->

    <div class="notification-overlay">
        <div class="notification-container">
            <p>Notification</p>
            <div class="container-nots">
                <div class="notification">
                   
                    
                </div>
            </div><!--end div.container-nots-->
        </div><!--end div.notification-container-->
    </div><!--end div.notification-overlay-->
    <?php }
    
    ?>

    <div class="chat-display" data-idlogin ="<?=$idlogin?>">
    <i class="fa fa-close"></i>
    <div class="container-fluid chat-container">
        <div class="col-md-3 col-xs-4 chat-user">
            <div class="your-name-chat">
                <span class="private-chat">Private</span>
                <span class="group-chat">Group</span>
            </div>
            <div class="group-chat-content">
            <?php 

            $stmtgroupchat = $con->prepare('SELECT * FROM `chat_group` WHERE status =1');
            $stmtgroupchat->execute();
            $rowshatgroup = $stmtgroupchat->fetchAll();
            foreach($rowshatgroup as $row){
            ?>
            <div class="group-name" data-frid="<?= $row['id']?>">
                <img src="layout\icons\<?= strtolower($row['Name'])?>.svg" class="img-circle-chat">
                <p class="name-user-chat"><?php echo $row['Name'] ?></p>
            </div><!--end div.friend-name-->
            <?php }
            ?>
            </div><!--end div.group-chat-->
            <div class="friend-chat">
                <?php 

                $stmt = $con->prepare('SELECT users.* FROM users,friends WHERE friends.friend1 = users.id AND friends.friend2 =:userid');
                $stmt->bindParam(':userid',$idlogin,PDO::PARAM_INT);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                foreach($rows as $row){
                ?>
                <div class="friend-name" data-frid="<?= $row['id']?>">
                    <img src="data\uploads\images\default.jpg" class="img-circle-chat">
                    <p class="name-user-chat"><?php echo $row['Name'] ?></p>
                </div><!--end div.friend-name-->
                <?php }
               ?>
            </div><!--end div.friend-chat-->
        </div><!--end div.col-md-3-->
        <div class="col-md-9 chat-content">
            <div class="name-user-content">

            </div><!--end div.name-user-content-->
            <div class="message-content-all">
                    <div class="message-content-append">
                    </div>
            </div><!--end div.message-content-->
            <div class="new-message">
                    <i class="fa fa-smile-o"></i>
                    <input type="text" class="new-message-input" placeholder="Type a message">
                    <span class="container-send-button">SEND<i class="fa fa-arrow-right"></i></span>
                    
            </div><!--end div.new-message-->
        </div><!--end div.col-md-9-->
    </div><!--end div.container-->  
    </div><!--end div.chat-->
    <div class="new-group">
        <div class="new-group-content">
            <span class="close-btn-ngroup"><i class="fa fa-close"></i></span>
            
            <div class="container">
                <div class="col-md-6">
                    <p>please type information of group to creating by admin</p>
                    <div class="form-group">
                        <label for="name">Name Of Group</label>
                        <input type="text" class="form-control group-name-one" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Description</label>
                        <input type="text" class="form-control des-group" id="description">
                    </div>
                    <div class="form-group">
                        <label for="email">Group Image</label>
                        <input type="file" class="form-control imag-group" id="image" accept=".jpg,.png">
                    </div>
                    <div class="btn btn-primary btn-new-group">Send To Admin</div>
                   <div class="error-cont-dis">
                       
                   </div>
                </div>
            </div>
        </div>
    </div>