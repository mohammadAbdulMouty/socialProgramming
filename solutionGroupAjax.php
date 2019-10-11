<?php
session_start();
include 'connect.php';
include 'includes/functions/function.php';
$color = array("#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d");

if(isset($_COOKIE['SPID'])){
    
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
     if($_GET['satatus'] == 1){
     $postid = (int)$_POST['postid'];
     $stmtCode = $con->prepare('SELECT * FROM `code_post` WHERE post_id = :postid');
     $stmtCode->bindParam(':postid',$postid,PDO::PARAM_INT);
     $stmtCode->execute();
     $stmtCodeFetch = $stmtCode->fetchAll();
     $stmtUser = $con->prepare('SELECT users.* FROM users,posts WHERE posts.id = :id AND users.id = posts.user_id');
     $stmtUser->bindParam(':id',$postid,PDO::PARAM_INT);
     $stmtUser->execute();
     $rowUser=$stmtUser->fetchAll();
     ?>
        <div class="orginal active" data-id="orginal" data-cid=<?php echo $stmtCodeFetch[0]['id'] ?>>
                <p><?php echo 'Main' ?></p>
                <span style="background: #70befc;"></span>
        </div>
     <?php
    $stmtCodeSolution = $con->prepare('SELECT * FROM `code_post_solution` WHERE post_code_id = :postcodeid');
    $stmtCodeSolution->bindParam(':postcodeid',$stmtCodeFetch[0]['id']);
    $stmtCodeSolution->execute();
    $stmtCodeSolutionFetch = $stmtCodeSolution->fetchAll();
   
    foreach($stmtCodeSolutionFetch as $stmtCode){
        $stmtUser2 = $con->prepare('SELECT users.* FROM users WHERE id = :id');
        $stmtUser2->bindParam(':id',$stmtCode['user_id'],PDO::PARAM_INT);
        $stmtUser2->execute();
        $rowUser2=$stmtUser2->fetchAll();
        ?>
        <div class="orginal" data-id="<?php echo $stmtCode['id'] ?>">
        <p><?php echo $rowUser2[0]['Name'] ?></p>
        <span style="background:<?php echo $color[array_rand($color)] ?>"></span>
        </div>

        <?php
    }
}
if($_GET['satatus'] == 2){
    $postid = (int)$_POST['postid'];
    $stmtCode = $con->prepare('SELECT * FROM `code_post` WHERE post_id = :postid');
    $stmtCode->bindParam(':postid',$postid,PDO::PARAM_INT);
    $stmtCode->execute();
    $rowCode = $stmtCode->fetchAll();
    $_COOKIE['lang']=$rowCode[0]['language'];
    echo $rowCode[0]['code'];
    

}
if($_GET['satatus'] == 3){
    $postid = (int)$_POST['postid'];
    $stmtR = $con->prepare('SELECT code_post_solution.* from code_post_solution INNER JOIN code_post ON code_post_solution.post_code_id = code_post.id INNER JOIN posts ON code_post.post_id = posts.id 
    where code_post_solution.user_id =:userid AND posts.id=:postsid');
    $stmtR->bindParam(':postsid',$postid,PDO::PARAM_INT);
    $stmtR->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmtR->execute();
    $count = $stmtR->rowCount();
    
    if($count==0){
        echo '<div class="fa fa-plus btn btn-success"></div>';
    }else{
        echo ' ';
    }
}
if($_GET['satatus'] == 4){
$langCompiler = array(
    'C#',
    'PHP',
    'Ruby',
    'Python',
    'Java',
    'Go',
    'C',
    'C++',
    'SQL',
    'MATLAB',
    'Kotlin',
    'NodeJS'
);
$stmt = $con->prepare('SELECT * FROM `code_post` WHERE id=:id');
$stmt->bindParam(':id',$_GET['gid'],PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchAll();


setcookie('lang',trim($row[0]['language']),time()+60*60*24*7,'/',NULL,NULL,true);

if(in_array($row[0]['language'],$langCompiler)){
    ?>
    <div class="input-output">
        <span class="chosse-io activee" data-show="result-cr" data-hide="input-com">output</span>
        <span class="chosse-io" data-show="input-com" data-hide="result-cr">input</span>
    </div>
    <div class="result-cr">
        <p>Press Execute to Compile And Run The Code</p>
    </div>
    <div class="input-com">
        <textarea placeholder="Enter value and sperator with comma `,`"></textarea>
    </div>
     <div class="btn btn-primary execute-compile">Execute</div>
     
    <?php
}else{
    ?>
<div class="result-cr">
        <p>this language not supported to compiled</p>
    </div>
    <?php
}

}
if($_GET['satatus'] == 5){
    if($_POST['child'] == 'orginal'){
        
    }else{
   $st = $con->prepare('SELECT * FROM code_post_solution where id =:id');
   $st->bindParam(':id',$_POST['child'],PDO::PARAM_INT);
   $st->execute();
   
   $rows = $st->fetchAll();
   if($rows[0]['user_id'] == $idlogin){
       echo '<div class="fa fa-edit btn btn-info btn-edit-solution">Edit</div>';
   }
}
}

    }