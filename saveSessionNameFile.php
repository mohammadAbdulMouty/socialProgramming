<?php 
session_start();
$id = $_GET['fileName'];
echo $id;
$_SESSION['file'] = $id;