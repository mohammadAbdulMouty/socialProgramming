<?php 
//"val"
//"cid"
//"sid"
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    
        $stmtcookies =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
        $stmtcookies->execute(array(
            ":cookies_token"=>sha1($_COOKIE['SPID'])
        ));
        $rowlogin =$stmtcookies->fetchAll();
        $idlogin = $rowlogin[0]['id'];
        if($_GET['status'] == 1){
        $stmt = $con->prepare('SELECT * FROM code_post_solution WHERE post_code_id = :cid AND id =:id');
        $stmt->bindParam(':cid',$_POST['cid'],PDO::PARAM_INT);
        $stmt->bindParam(':id',$_POST['sid'],PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if($rows[0]['user_id'] = $idlogin){
            if($rows[0]['code'] != $_POST['val']){
                echo 'save';
            }else{
                echo 'no save';
            }
        }
    }
    if($_GET['status'] == 2){
        $stmt2 = $con->prepare('UPDATE `code_post_solution` SET `code`=:code WHERE id =:id AND post_code_id = :codePostid');
        $stmt2->bindParam(':code',$_POST['val']);
        $stmt2->bindParam(':id',$_POST['sid'],PDO::PARAM_INT);
        $stmt2->bindParam(':codePostid',$_POST['cid'],PDO::PARAM_INT);
        if($stmt2->execute()){
            echo 'save';
        }
       
    }


    }
