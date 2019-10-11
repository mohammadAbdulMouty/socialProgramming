<?php
$pageTitle = 'Reset Password';
include 'init.php';


    if($_GET['d']){
    if(isset($_POST['newPass'])){
        echo 'mohammad';
        $stmt = $con->prepare('SELECT * FROM users WHERE token = ?');
        $stmt->execute(array($_GET['d']));
        $item=$stmt->fetch();
        echo $item['Name'];
        $pass1 = $_POST['newpas'];
        $pass2 = $_POST['confirmnewpass'];
        $cstrong = true;
        $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
        if($pass1 == $pass2){
            $stmt2 =$con->prepare('UPDATE users set password = ? , token = ? WHERE Name = ? ');
            $stmt2->execute(array(sha1($pass1),$token,$item['Name']));
            

        }else{
            $errorMessage = 'Sorry Password Is Not Match';
        }
    }
    }
?>
<form action='<?php echo "?d=".$_GET['d']."" ?>' class="form-signup" method="POST">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Reset Password</div>
            </div>
            <div class="panel-body">
                <label for="pass" >New Pssword <sup style="font-size:12px">*</sup></label>    
                <div class="input-group relative">
                    <i class="fa fa-eye-slash moveeye"></i>
                    <span class="input-group-addon" id="sizing-addon2"><i class='fa fa-lock fa-fw'></i></span>
                    <input type="password" class="form-control" name="newpas" id="pass" autocomplete="off" >
                    
                </div><!--end the div.form-group(password)-->
                <label for="password">Confirm New Password <sup style="font-size:12px">*</sup></label>
                <div class="input-group relative">
                    <i class="fa fa-eye-slash moveeye"></i>
                    <span class="input-group-addon"><i class='fa fa-lock fa-fw'></i></span>
                    <input type="password" class="form-control" name="confirmnewpass" id="newpassword" autocomplete="off" >
                </div><!--end the div.form-group(confirm password)-->
                <div class="input-group relative">
                    <input type="submit" class="btn btn-success" name="newPass" value="save">
                    <i class="fa fa-save"></i>
                </div><!--end the div.form-group(confirm password)-->
            </div><!--end the div.panel-body -->  
        </div><!--end the div.panel panel-info -->
        
        <?php
            if(isset($errorMessage)){
                echo '<div class="alert alert-danger">';
                echo $errorMessage.' </div>';
            }
        ?>
       
        </form>


<?php
include $tpl.'footer.php';
?>