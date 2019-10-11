<?php
setcookie('SPIDadmin' , '1' , time()-3600,'/');
header('Location: login.php');
?>