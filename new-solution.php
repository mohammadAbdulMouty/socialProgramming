<?php
    $postonload ="mm";
    $pageTitle = 'Profile';
    include 'init.php';
    if(isset($_COOKIE['SPID'])){
        $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
         $stmt->execute(array(
             ":cookies_token"=>sha1($_COOKIE['SPID'])
         ));
         $rowlogin = $stmt->fetchAll();
         $idlogin = $rowlogin[0]['id'];
         
?>



<?php
    $color = array("#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d");
    ?>
    <div class="orginal active new-element">
    <p><?php echo $rowlogin[0]['Name'] ?></p>
    <span style="background:<?php echo $color[array_rand($color)]; ?>"></span>
    </div>
    <?php
   
    }

    ?>