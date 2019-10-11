<?php
include 'connect.php';
$data = $_POST['image'];
$stmt =$con->prepare("SELECT users.* FROM users INNER JOIN cookies_token ON users.id = cookies_token.userid WHERE cookies_token.token = :cookies_token");
$stmt->execute(array(
    ":cookies_token"=>sha1($_COOKIE['SPID'])
));
$rowlogin = $stmt->fetchAll();
$idlogin = $rowlogin[0]['id'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';
file_put_contents('data\uploads\images\\'.$imageName, $data);
$select = $con->prepare('UPDATE users set `image` =:image WHERE `id` =:id');
$select->bindParam(':image',$imageName,PDO::PARAM_STR);
$select->bindParam(':id',$idlogin,PDO::PARAM_INT);
$select->execute();

