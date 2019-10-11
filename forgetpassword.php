<?php
$loginbg='';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$pageTitle = 'forget password';
include 'init.php';
if(isset($_POST['sendEmail'])){
    if(isset($_POST['email'])){
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $count = checkItem('Email','users',$email);
        $stmt = $con->prepare('SELECT * from users where Email =?');
        $stmt->execute(array($email));
        $count = $stmt->rowCount();
        
        if($count){
                    $item = $stmt->fetch();                             // Passing `true` enables exceptions
                    try {
                        
                        $mail = new PHPMailer(true); // create a new object
                        $mail->IsSMTP(); // enable SMTP
                        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                        $mail->SMTPAuth =true; // authentication enabled
                        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                        $mail->Host = "smtp.gmail.com";
                        $mail->Port = 587; // or 587
                        $mail->IsHTML(true);
                        $mail->Username = "mabadulmouty@gmail.com";
                        $mail->Password = "Webnuttertools13";
                        $mail->SetFrom("ababdoiuy@gmail.com");
                        
                             // Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    = 'please click in the link <a href="https://socialprogramming.000webhostapp.com/Sprogramming/resetpas.php?d='.$item['token'].'">click</a>';
                        $mail->AltBody = 'Thank you';
                        $mail->AddAddress($email);
                        $mail->send();
                        $messageSuccess = 'Message has been sent';
                    } catch (Exception $e) {
                        echo $e;
                    }
                }else{
                        echo 'email is not exists';
                    }
                }
            }

?>
<div class="container">
    
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-signup" method="POST">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <div class="panel-title">Forgot password</div>
            </div>
            <div class="panel-body">
                <label for="email" >Please input your email</label>    
                <div class="input-group relative">
                    <span class="input-group-addon" id="sizing-addon2"><i class='fa fa-envelope  fa-fw'></i></span>
                    <input type="email" class="form-control" name="email" id="email" autocomplete="off" >
                    
                </div><!--end the div.form-group(name)-->
                <div class="input-group relative">
                    <input type="submit" class="btn btn-info" name="sendEmail" value="send"  >
                    <i class="fa fa-envelope"></i>
                </div><!--end the div.form-group(confirm password)-->
            </div><!--end the div.panel-body -->  
        </div><!--end the div.panel panel-info -->
        
        <?php
            if(isset($messageSuccess)){
                echo '<div class="alert alert-success">';
                echo $messageSuccess.' </div>';
            }
        ?>
       
        </form>
</div>



