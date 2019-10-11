<?php
include 'connect.php';
$postId = $_GET['postid'];
$stmt = $con->prepare('SELECT * FROM `code_post` WHERE post_id = :postid');
$stmt->execute(array('postid'=>$postId));
$rows = $stmt->fetchAll();
echo $rows[0]['code'];