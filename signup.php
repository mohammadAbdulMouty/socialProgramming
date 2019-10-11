<?php
$loginbg='';
$pageTitle = 'sing up';
include 'init.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if(isset($_POST['sendform'])){
    $name      = $_POST['name'];
    $email     = $_POST['email'];
    $password1 = $_POST['password'];
    $password2 = $_POST['confirmpass'];
    $cstrong = true;
    $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
    $formError =array();
    if(isset($name)){
       $name  = filter_var($name,FILTER_SANITIZE_STRING);
       if(strlen($name)<4){
           $formError[]='Username Must Be Larger The 4 Characters';
       }
    }
    if(isset($password1) && isset($password2)){
        if(empty($password1)||empty($password2)){
            $formError[]='Sorry Password Filed Can\'t Be Empty';
        }
        else if(strlen($password1)<5){
            $formError[]='Password Must be Larger the 5 characters';
        }
        $pass1 = sha1($password1);
        $pass2 = sha1($password2);
        if($pass1 !== $pass2){
            $formError[]='Sorry Password Is Not Match';
        }
    }
    
    if(isset($email)){
        $email=filter_var($email , FILTER_SANITIZE_EMAIL);
        if(empty($email)){
            $formError[]='Sorry Email Filed Cant\'t Be Empty';
        }
    }
    $result = CheckCaptcha($_POST['g-recaptcha-response']);
    if ($result['success']) {
    if(empty($formError)){
        $stmt=$con->prepare('INSERT INTO `users`(`Name`, `Email`, `password`, `token`) VALUES (:zname,:zemail,:zpass,:token)');
        $stmt->execute(array(
            'zname'=>$name,
            'zemail'=>$email,
            'zpass'=>$pass1,
            ':token'=>$token
        ));
        $successMsg = 'Congrats You are Now Register User';
        header('Location: login.php');
    }
}else{
    $formError[] = 'Please Cheack the security CAPTCH';
}

}
}
?>
<div class="container">
    
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-signup" method="POST">
        <div class="panel panel-info ">
            <div class="panel-heading">Sign up</div>
            <div class="panel-body">
                <label for="name" >Name</label>    
                <div class="input-group relative">
                    <span class="input-group-addon" id="sizing-addon2"><i class='fa fa-user  fa-fw'></i></span>
                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                    <span id="chk-user"></span>
                   
                </div><!--end the div.form-group(name)-->
                <label for="email">Email</label>
                <div class="input-group relative">
                   
                    <span class="input-group-addon"> <i class='fa fa-envelope fa-fw'></i></span> 
                    <input type="email" class="form-control" name="email" id="email" autocomplete="off" >
                </div><!--end the div.form-group(email)-->
                <label for="password">Password</label>
                <div class="input-group relative">
                    <i class="fa fa-eye-slash moveeye"></i>
                    <span class="input-group-addon"><i class='fa fa-lock fa-fw'></i></span>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" >
                    
                </div><!--end the div.form-group(password)-->
                <label for="password">Confirm Password</label>
                <div class="input-group relative">
                    <i class="fa fa-eye-slash moveeye"></i>
                    <span class="input-group-addon"><i class='fa fa-lock fa-fw'></i></span>
                    <input type="password" class="form-control" name="confirmpass" id="repassword" autocomplete="off" >
                </div><!--end the div.form-group(confirm password)-->
                <div class="g-recaptcha" data-sitekey="6LdeUUEUAAAAAMZRawe6uZZgqY5GmQ-AcZml-Kd-"></div>
                <div class="input-group relative">
                    <input type="submit" class="btn btn-info submitbtn" name="sendform" value="Register Now"  >
                    <i class="fa fa-send "></i>
                </div><!--end the div.form-group(confirm password)-->
            </div><!--end the div.panel-body -->  
        </div><!--end the div.panel panel-info -->  
    
        
    

<?php
if(isset($usernameShk)){
echo $usernameShk;
}
if(!empty($formError)){
    echo '<div class="errorAlert">';
    foreach($formError as $error){
        
        echo $error.'<br>';
        
    }
    
}
if(isset($successMsg)){
    echo '<div class="successAlert alert-dismissible">';
    echo $successMsg ;
    echo '</div>';

}

echo '</div></form></div>';//end the container
include $tpl.'footer.php';
?>