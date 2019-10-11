<?php 
include 'connect.php';

if($_POST['status']==1){
$likestmt = '%'.$_POST['query'].'%';
 $stmt = $con->prepare("SELECT * FROM users WHERE Name LIKE :name");
$stmt->bindParam(':name',$likestmt,PDO::PARAM_STR);
 $stmt->execute();
 $rows = $stmt->fetchAll();
 foreach($rows as $row){
 echo '<li class="list-unstyled">';
    echo "<img src='data\uploads\images"."\\".$row['image']."'>";
    echo "<p>".$row['Name']."</p>";
 
 echo '</li>';

 }
}

