<?php
include 'connect.php';
if(isset($_COOKIE['SPID'])){
    $stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
     $stmt->execute(array(
         ":cookies_token"=>sha1($_COOKIE['SPID'])
     ));
     $rand = rand(0,10000000);
     
     $rowlogin = $stmt->fetchAll();
     $idlogin = $rowlogin[0]['id'];
$folder_name = $_FILES['file']['name'];
$temp = $_FILES['file']['tmp_name'];

$folder =substr($folder_name,0,strrpos($folder_name,'.'));

mkdir('projects/'.$folder);
if(move_uploaded_file($temp,'projects/'.$folder_name)){
    $zip = new ZipArchive;
    
    $res = $zip->open('projects/'.$folder_name);
    $zip->extractTo('projects/'.$folder.'');
    $zip->close();

    $stmt = $con->prepare('INSERT INTO `project`(`id`, `Name`, `data-create`)
    VALUES (:id,:name,now())');
    $stmt->bindParam(':id',$rand,PDO::PARAM_INT);
    $stmt->bindParam(':name',$folder,PDO::PARAM_STR);
    $stmt->execute();
    $path = getcwd().'\projects';
    $stmt2 = $con->prepare('INSERT INTO `user_project`(`userid`, `projectid`, `status`) VALUES (:userid,:proid,1)');
    $stmt2->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt2->bindParam(':proid',$rand,PDO::PARAM_INT);
    $stmt2->execute();
    //SELECT project.* FROM project,user_project WHERE project.id = user_project.projectid AND user_project.userid = 7
    $stmt3 = $con->prepare('SELECT project.* FROM project,user_project WHERE project.id = user_project.projectid AND user_project.userid =:userid');
    $stmt3->bindParam(':userid',$idlogin,PDO::PARAM_INT);
    $stmt3->execute();
    $rows = $stmt3->fetchAll();
    foreach($rows as $row){
        ?>

<div class="col-md-4 body-folder">
<a href="projectContent.php?gid=<?php echo $row['id'] ?>">
    <div class="control-project">
        <i class="fa fa-close"></i>
    </div><!--end div.control-project-->
    <div class="project">
        <span class="glyphicon glyphicon-folder-open"></span>
        <h4><?php echo $row['Name']?></h4>
    </div><!--end div.project-->
</a>
</div><!--end div.col-md-4-->
<?php
    }

}

}