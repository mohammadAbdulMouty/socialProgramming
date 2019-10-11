<?php
$loginbg='';
include 'init.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.id FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
    $stmt->execute(array(
        ":cookies_token"=>sha1($_COOKIE['SPID'])
    ));
    $rowlogin = $stmt->fetchAll();
    
    $profileid = $rowlogin[0]['id'];
    
   header('Location: index.php?id='.$profileid.'');
} 
$pageTitle = 'Sign In';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['sendform'])){
        $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $password  = $_POST['password'];
        if($name == 'admin' && $password == 'admin'){
            setcookie('SPIDadmin','admin',time()+60*60*24*7,'/',NULL,NULL,true);
            header('Location: admin.php');
        }else{
        $stat = $con->prepare('SELECT * FROM users WHERE Name = ? AND password = ?');
        $stat->execute(array($name,sha1($password)));
        $count = $stat->rowCount();
        if($count){  
           $rows =  $stat->fetch();
           $userid = $rows['id'];
           $cstrong = true;
           $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
           $stat2 =$con->prepare('INSERT INTO `cookies_token`(`token`, `userid`) VALUES (:token,:userid)');
           $stat2->execute(array(
               'token'  =>sha1($token),
               'userid' =>$userid
           ));
           setcookie('SPID',$token,time()+60*60*24*7,'/',NULL,NULL,true);
           setcookie('SPID_','1',time()+60*60*24*3,'/',NULL,NULL,true);
           header('Location: index.php?id='.$userid.'');
           }else{
            $errorMessage ='username or passwrod not exists';
        }
    }
    }
}
?>

<div class="container">
    
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-signup" method="POST" autocomplete="off">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
                <div class="forget-password"><a href="forgetpassword.php">Forgot password?</a></div>
            </div>
            <div class="panel-body">
                <label for="username" >Name</label>    
                <div class="input-group relative">
                    <span class="input-group-addon" id="sizing-addon2"><i class='fa fa-user  fa-fw'></i></span>
                    <input type="text" class="form-control" name="name" id="username" autocomplete="off" >
                    <span id="chk-user"></span>
                   
                </div><!--end the div.form-group(name)-->
                <!-- disables autocomplete --><input type="text" style="display:none">
                <!-- disables autocomplete --><input type="password" style="display:none">
                <label for="password">Password</label>
                <div class="input-group relative">
                <span class="input-group-addon"><i class='fa fa-lock fa-fw'></i></span>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" >  
                </div><!--end the div.form-group(password)-->
                
                <div class="input-group relative">
                    <input type="submit" class="btn btn-info" name="sendform" value="Login" autocomplete="new-password" >
                    <i class="fa fa-send"></i>
                </div><!--end the div.form-group(confirm password)-->
                <hr>
                <div>
                    Don't have an account! <a href="signup.php">Sign Up Here</a>
                </div>
            </div><!--end the div.panel-body -->  
        </div><!--end the div.panel panel-info -->
        <?php
        if(isset($errorMessage)){
        echo '<div class="panel panel-warning">';
        echo "$errorMessage </div>";
        }
        ?>  
     </form>
</div>

<?php
include $tpl.'footer.php';
?>


