<?php
session_start();
$filePath = $_SESSION['file'];
$array = explode('\\',$filePath);
echo end($array);